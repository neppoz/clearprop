<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes([
    'register' => true,
    'verify' => true,
    'reset' => true
]);

// Complete profile after registration
Route::group(['middleware' => ['auth']], function () {
    Route::get('register-step2', 'Auth\RegisterStep2Controller@showForm');
    Route::post('register-step2', 'Auth\RegisterStep2Controller@postForm')->name('register.step2');
});

// Frontend
Route::group(['prefix' => 'pilot', 'as' => 'pilot.', 'namespace' => 'Pilot', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('welcome');

    // Bookings
    Route::post('bookings/slot/{id}', 'BookingsController@bookSlot')->name('bookings.slot');
    Route::delete('bookings/destroy', 'BookingsController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingsController');

    // Ratings
    Route::get('ratings/getRatingsForUser', 'RatingsController@getRatingsForUser')->name('ratings.getRatingsForUser');

    // Activities
//    Route::get('activities/userActivities/{user_id}', 'ActivitiesController@getActivitiesByUser')->name('activities.getActivitiesByUser');
//    Route::get('activities/instructorActivities/{user_id}', 'ActivitiesController@getActivitiesByUserAsInstructor')->name('activities.getActivitiesByUserAsInstructor');
//    Route::get('activities/planeActivities/{plane_id}', 'ActivitiesController@getActivitiesByPlane')->name('activities.getActivitiesByPlane');
    Route::delete('activities/destroy', 'ActivitiesController@massDestroy')->name('activities.massDestroy');
    Route::resource('activities', 'ActivitiesController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);
});


// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::post('users/report', 'UsersReportController@index')->name('users.report');
    Route::post('users/individualReport/{user}', 'UsersReportController@individualReport')->name('users.individualReport');
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

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
    Route::get('activities/userActivities/{user_id}', 'ActivitiesController@getActivitiesByUser')->name('activities.getActivitiesByUser');
    Route::get('activities/instructorActivities/{user_id}', 'ActivitiesController@getActivitiesByUserAsInstructor')->name('activities.getActivitiesByUserAsInstructor');
    Route::get('activities/planeActivities/{plane_id}', 'ActivitiesController@getActivitiesByPlane')->name('activities.getActivitiesByPlane');
    Route::delete('activities/destroy', 'ActivitiesController@massDestroy')->name('activities.massDestroy');
    Route::resource('activities', 'ActivitiesController');

    // Bookings
    Route::delete('bookings/destroy', 'BookingsController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingsController');

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

    // Ratings
    Route::get('ratings/getRatingsForUser', 'RatingsController@getRatingsForUser')->name('ratings.getRatingsForUser');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
});

// Route to API docs
Route::group(['middleware' => ['auth']], function () {
    Route::view('/docs', 'scribe.index');
});
