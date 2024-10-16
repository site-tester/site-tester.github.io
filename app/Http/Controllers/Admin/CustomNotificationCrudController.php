<?php

namespace App\Http\Controllers\Admin;

use App\Models\BackpackUser;
use App\Models\CustomNotification;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Pestopancake\LaravelBackpackNotifications\Http\Controllers\NotificationCrudController;
use Carbon\Carbon;
use CRUD;

class CustomNotificationCrudController extends NotificationCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function hasAdminAccess()
    {
        try {
            return backpack_user()->hasPermissionTo(
                config('backpack.databasenotifications.admin_permission_name'),
                config('auth.defaults.guard', 'web')
            );
        } catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) {
            return false;
        }
    }

    public function setup()
    {
        $this->crud->setModel(config('backpack.databasenotifications.notification_model'));
        $this->crud->setRoute(config('backpack.base.route_prefix').'/notification');
        $this->crud->setEntityNameStrings('notification', 'notifications');

        $this->crud->addClause('orderBy', 'created_at', 'desc');

        $showAllUsers = $this->hasAdminAccess() && \Request::get('show_all');
        if (! $showAllUsers) {
            $this->crud->addClause('where', 'notifiable_id', backpack_user()->id);
            $this->crud->addClause('where', 'notifiable_type', config('backpack.base.user_model_fqn'));
        }

        if (! \Request::get('show_dismissed')) {
            $this->crud->addClause('whereNull', 'read_at');
        }

        $this->crud->addButtonFromModelFunction('top', 'dismiss_all', 'dismissAllButton', 'beginning');

        $this->crud->addButtonFromModelFunction('line', 'action', 'actionButton', 'end');
        $this->crud->addButtonFromModelFunction('line', 'dismiss', 'dismissButton', 'end');

        $this->crud->denyAccess(['create', 'delete', 'update', 'show']);
    }

    protected function setupListOperation()
{
    $this->crud->setActionsColumnPriority(-1);
    // $this->crud->disableResponsiveTable();

    // Conditionally show dismissed notifications
    if (\Request::get('show_dismissed')) {
        // Clause for showing dismissed notifications (where read_at is not null)
        $this->crud->addClause('whereNotNull', 'read_at');
    } else {
        // By default, show only unread notifications (where read_at is null)
        $this->crud->addClause('whereNull', 'read_at');
    }

    // Conditionally show notifications for all users if admin access
    if ($this->hasAdminAccess() && \Request::get('show_all')) {
        // No additional clauses for admins viewing all notifications
    } else {
        // Show only notifications for the current user
        $this->crud->addClause('where', 'notifiable_id', backpack_user()->id);
        $this->crud->addClause('where', 'notifiable_type', config('backpack.base.user_model_fqn'));
    }

    // Columns

    // Date column
    $this->crud->addColumn([
        'label' => 'Date',
        'type' => 'datetime',
        'name' => 'created_at',
    ]);

    // Message column with custom HTML
    $this->crud->addColumn([
        'name' => 'message',
        'label' => 'Message',
        'type' => 'custom_html',
        'priority' => -1,
        'value' => function ($entry) {
            return '<div style="display:inline-block; max-width:100%; white-space: pre-wrap;">' .
                ($entry->data->message_long ?? $entry->data->message ?? '-') .
                '</div>';
        },
    ]);

    // Add a column for showing who the notification is for, if the user has admin access
    if ($this->hasAdminAccess() && \Request::get('show_all')) {
        $this->crud->addColumn([
            'label' => 'For',
            'type' => 'closure',
            'name' => 'notifiable_id',
            'function' => function ($entry) {
                $user = BackpackUser::find($entry->notifiable_id);
                return $user->displayName ?? '-';
            },
        ]);
    }
}


    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->setupListOperation();
    }

    protected function setupCreateOperation()
    {
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function dismissAll()
    {
        backpack_user()->unreadNotifications->markAsRead();

        \Alert::success('All notifications dismissed')->flash();

        return redirect()->back();
    }

    public function dismiss($notificationId)
    {
        $notificationClass = config('backpack.databasenotifications.notification_model');
        $notification = $notificationClass::findOrFail($notificationId);

        $notification->read_at = Carbon::now();
        $notification->save();

        \Alert::success('Notification dismissed')->flash();

        return redirect()->back();
    }

    public function unreadCount()
    {
        $count = backpack_user()->unreadNotifications->count();

        $lastNotification = backpack_user()->unreadNotifications()->orderBy('created_at', 'desc')->first();

        return response()->json([
            'count' => $count,
            'last_notification' => $lastNotification ? $lastNotification->data : null,
        ]);
    }

    public function readDonationNotification($id){
        $notification = CustomNotification::where("data->donation_id",$id)->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->read_at = Carbon::now();
            $notification->save();
        }

        $donationId = $notification->data->donation_id ?? null;

        if ($donationId) {
            // Redirect to the donation show page (assuming you have a route for donation details)
            return redirect()->route('donation.show', ['id' => $donationId]);
        }

        // If no donation id, just show the notification or another default action
        return redirect()->back()->with('message', 'Notification marked as read');
    }
}
