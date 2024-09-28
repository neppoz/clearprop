<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RatingsController;

Auth::routes([
    'login' => true,
    'logout' => true,
    'register' => false,
    'reset' => true,   // for resetting passwords
    'confirm' => false,  // for additional password confirmations
    'verify' => false,  // for email verification
]);

// Main routes
Route::redirect('/', '/login');
Route::redirect('/pilot', '/home');
Route::get('/home', function () {
    return redirect()->route('app.home');
});

Route::group(['prefix' => 'app', 'as' => 'app.', 'middleware' => ['auth']], function () {

    Route::get('/', [HomeController::class, 'redirectToAdminPanel'])->name('home');
//    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Activities
    Route::get('activities/userActivities/{user_id}', [ActivitiesController::class, 'getActivitiesByUser'])->name('activities.getActivitiesByUser');
    Route::get('activities/instructorActivities/{user_id}', [ActivitiesController::class, 'getActivitiesByUserAsInstructor'])->name('activities.getActivitiesByUserAsInstructor');
    Route::get('activities/planeActivities/{plane_id}', [ActivitiesController::class, 'getActivitiesByPlane'])->name('activities.getActivitiesByPlane');
    Route::delete('activities/destroy', [ActivitiesController::class, 'massDestroy'])->name('activities.massDestroy');
    Route::resource('activities', ActivitiesController::class);

    // Bookings
    Route::post('bookings/book/{id}', [BookingsController::class, 'book'])->name('bookings.book');
    Route::post('bookings/revoke/{id}', [BookingsController::class, 'revoke'])->name('bookings.revoke');
    Route::delete('bookings/destroy', [BookingsController::class, 'massDestroy'])->name('bookings.massDestroy');
    Route::resource('bookings', BookingsController::class);

    // Ratings
    Route::get('ratings/getRatingsForUser', [RatingsController::class, 'getRatingsForUser'])->name('ratings.getRatingsForUser');

});

// Change profile
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
    Route::post('password', 'ChangePasswordController@update')->name('password.update');
    Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
    Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
});

// Frontend
Route::group(['prefix' => 'pilot', 'as' => 'pilot.', 'namespace' => 'Pilot', 'middleware' => ['auth', 'verified']], function () {
//    Route::get('/', [HomeController::class, 'index'])->name('home');

//    // Bookings
//    Route::post('bookings/book/{id}', 'BookingsController@book')->name('bookings.book');
//    Route::post('bookings/revoke/{id}', 'BookingsController@revoke')->name('bookings.revoke');
//    Route::delete('bookings/destroy', 'BookingsController@massDestroy')->name('bookings.massDestroy');
//    Route::resource('bookings', 'BookingsController');

//    // Ratings
//    Route::get('ratings/getRatingsForUser', 'RatingsController@getRatingsForUser')->name('ratings.getRatingsForUser');

    // Activities
//    Route::delete('activities/destroy', 'ActivitiesController@massDestroy')->name('activities.massDestroy');
//    Route::resource('activities', 'ActivitiesController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Billings
    Route::resource('billing', 'BillingController');

    // Checkout
    Route::post('checkout/charge', 'CheckoutController@charge')->name('checkout.charge');
    Route::post('checkout/paymentIntent', 'CheckoutController@paymentIntent')->name('checkout.paymentIntent');
    Route::post('checkout/processCheckout', 'CheckoutController@processCheckout')->name('checkout.processCheckout');

});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'verified']], function () {
//Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin', 'verified']], function () {
//    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::get('users/deletedUsers', [UsersController::class, 'getDeletedUsers'])->name('users.getDeletedUsers');
    Route::post('users/undelete/{user_id}', [UsersController::class, 'undelete'])->name('users.undelete');
    Route::post('users/report', 'UsersReportController@index')->name('users.report');
    Route::post('users/individualReport/{user}', 'UsersReportController@individualReport')->name('users.individualReport');
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/getAlertCount', 'UserAlertsController@getAlertCount')->name('user-alerts.getAlertCount');
    Route::post('user-alerts/mark-as-read', 'UserAlertsController@markNotification')->name('user-alerts.markNotification');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update', 'updateRead', 'markNotification']]);

    // Planes
    Route::delete('planes/destroy', 'PlanesController@massDestroy')->name('planes.massDestroy');
    Route::resource('planes', 'PlanesController');

    // Factors
    Route::delete('factors/destroy', 'FactorsController@massDestroy')->name('factors.massDestroy');
    Route::resource('factors', 'FactorsController');

    // Types
    Route::get('types/getTypeByFactor', 'TypesController@getTypeByFactor')->name('types.getTypeByFactor');
    Route::delete('types/destroy', 'TypesController@massDestroy')->name('types.massDestroy');
    Route::resource('types', 'TypesController');

    // Activities
    Route::get('activities/userActivities/{user_id}', [ActivitiesController::class, 'getActivitiesByUser'])->name('activities.getActivitiesByUser');
    Route::get('activities/instructorActivities/{user_id}', [ActivitiesController::class, 'getActivitiesByUserAsInstructor'])->name('activities.getActivitiesByUserAsInstructor');
    Route::get('activities/planeActivities/{plane_id}', [ActivitiesController::class, 'getActivitiesByPlane'])->name('activities.getActivitiesByPlane');
    Route::delete('activities/destroy', [ActivitiesController::class, 'massDestroy'])->name('activities.massDestroy');
    Route::resource('activities', ActivitiesController::class);

//    // Bookings
//    Route::delete('bookings/destroy', 'BookingsController@massDestroy')->name('bookings.massDestroy');
//    Route::resource('bookings', 'BookingsController');

    // Parameters
    Route::delete('parameters/destroy', 'ParametersController@massDestroy')->name('parameters.massDestroy');
    Route::resource('parameters', 'ParametersController');

    // Activity Reports
    Route::resource('activity-reports', 'ActivityReportController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Expense Categories
    Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
    Route::resource('expense-categories', 'ExpenseCategoryController');

    // Income Categories
    Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
    Route::resource('income-categories', 'IncomeCategoryController');

    // Expenses
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::resource('expenses', 'ExpenseController');

    // Incomes
    Route::get('activities/userIncomes/{user_id}', 'IncomeController@getIncomesByUser')->name('incomes.getIncomesByUser');
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');

    // Expense Reports
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');

    // Slots
    Route::delete('slots/destroy', 'SlotsController@massDestroy')->name('slots.massDestroy');
    Route::resource('slots', 'SlotsController');

//    // Ratings
//    Route::get('ratings/getRatingsForUser', 'RatingsController@getRatingsForUser')->name('ratings.getRatingsForUser');

    // Asset Categories
    Route::delete('asset-categories/destroy', 'AssetCategoryController@massDestroy')->name('asset-categories.massDestroy');
    Route::resource('asset-categories', 'AssetCategoryController');

    // Asset Locations
    Route::delete('asset-locations/destroy', 'AssetLocationController@massDestroy')->name('asset-locations.massDestroy');
    Route::resource('asset-locations', 'AssetLocationController');

    // Asset Statuses
    Route::delete('asset-statuses/destroy', 'AssetStatusController@massDestroy')->name('asset-statuses.massDestroy');
    Route::resource('asset-statuses', 'AssetStatusController');

    // Assets
    Route::delete('assets/destroy', 'AssetController@massDestroy')->name('assets.massDestroy');
    Route::post('assets/media', 'AssetController@storeMedia')->name('assets.storeMedia');
    Route::post('assets/ckmedia', 'AssetController@storeCKEditorImages')->name('assets.storeCKEditorImages');
    Route::resource('assets', 'AssetController');

    // Assets Histories
//    Route::resource('assets-histories', 'AssetsHistoryController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
});
