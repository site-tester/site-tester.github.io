<?php

namespace App\Models;

use Pestopancake\LaravelBackpackNotifications\Models\Notification;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CustomNotification extends Notification
{
    use CrudTrait;

    protected $table = 'notifications';
    public $timestamps = true;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data',
        'read_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // protected $casts = ['data' => 'array'];

    public function getDisplayNameAttribute()
    {
        return $this->id;
    }

    public function getDataAttribute()
    {
        return json_decode($this->attributes['data']);
    }

    public function dismissAllButton($crud)
    {
        if (backpack_user()->unreadNotifications()->count()) {
            return '<a href="' . route('crud.notification.dismissall') . '" class="btn btn-default ladda-button">Dismiss All</a>';
        }
    }

    public function dismissButton($crud)
    {
        if ($this->read_at) {
            return '';
        }

        return '<a href="' . route('crud.notification.dismiss', ['notification_id' => $this->id]) . '" class="btn btn-xs btn-default ladda-button">Dismiss</a>';
    }

    public function actionButton()
    {
        $str = '';
        if (!empty($this->data->action)) {
            $str = '<a href="' . $this->data->action->url . '" class="btn btn-primary">' . ucfirst($this->data->action->title) . '</a>';
        } elseif ($this->data->action_href ?? false) {
            $str = '<a href="' . $this->data->action_href . '" class="btn btn-primary">' . ucfirst($this->data->action_text) . '</a>';
        }

        return $str;
    }
    public function showNotificationButton($crud)
    {

        $donationId = $this->data->donation_id ?? null;  // Assuming `donation_id` is part of the notification data

        if ($donationId) {
            // return '<a class="btn btn-sm btn-link" href="' . url('admin/donation/' . $donationId .'/show') . '"><i class="la la-eye"></i> Show Donation </a>';
            return '<a class="btn btn-sm btn-link" href="' . route('notification.read' , $donationId ) . '"><i class="la la-eye"></i> Show Donation </a>';
        }

        return '';
    }

}
