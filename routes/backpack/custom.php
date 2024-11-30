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
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('municipality-dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'adminDashboard']);
    Route::crud('users', 'UserCrudController');
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
    Route::crud('article', 'ArticleCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('tag', 'TagCrudController');
    Route::crud('request-donation', 'RequestDonationCrudController');
    Route::crud('disaster-request', 'DisasterReportCrudController');
    Route::crud('disaster-report-verification', 'RequestDonationVerificationCrudController');
    Route::crud('donation-transfer', 'TransferDonationController');
    Route::post('update-verification-status/{id}', [
        'uses' => 'RequestDonationVerificationCrudController@updateStatus',
        'as' => 'update.verification.status',
    ]);
    Route::post('update-donation-verification-status/{id}', [
        'uses' => 'DonationCrudController@updateStatus',
        'as' => 'update.donation.verification.status',
    ]);
    Route::post('approve-donation/{id}', [
        'uses' => 'DonationCrudController@approveDonation',
        'as' => 'donation.approve',
    ]);
    Route::post('receive-donation/{id}', [
        'uses' => 'DonationCrudController@receiveDonation',
        'as' => 'donation.receive',
    ]);
    Route::post('distribute-donation/{id}', [
        'uses' => 'DonationCrudController@distributeDonation',
        'as' => 'donation.distribute',
    ]);
    Route::crud('transfer-donation', 'TransferDonationController');

    // New Dashboard ChartJs Routes
    Route::get('donations-chart-data', [App\Http\Controllers\Admin\DashboardController::class, 'donationsChartData']);
    Route::get('donation-breakdown-chart-data', [App\Http\Controllers\Admin\DashboardController::class, 'donationBreakdownChartData']);
    Route::get('inventory-data', [App\Http\Controllers\Admin\DashboardController::class, 'getInventoryData']);


}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
