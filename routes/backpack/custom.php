<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('barangay', 'BarangayCrudController');
    Route::crud('donation', 'DonationCrudController');
    Route::crud('item', 'ItemCrudController');
    // Route::crud('notification', 'NotificationCrudController');
    Route::crud('notification', 'CustomNotificationCrudController');
    // Notifications
    Route::get('notification/unreadcount', [
        'uses' => 'NotificationCrudController@unreadCount',
        'as' => 'crud.notification.unreadcount',
    ]);
    Route::get('notification/dismissall', [
        'uses' => 'NotificationCrudController@dismissAll',
        'as' => 'crud.notification.dismissall',
    ]);
    Route::get('notification/{notification_id}/dismiss', [
        'uses' => 'NotificationCrudController@dismiss',
        'as' => 'crud.notification.dismiss',
    ]);
    Route::get('notification/{notification_id}/read', [
        'uses' => 'CustomNotificationCrudController@readDonationNotification',
        'as' => 'notification.read',
    ]);


}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
