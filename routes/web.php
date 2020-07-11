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

// Route to API docs
Route::group(['middleware' => ['auth']], function () {
    Route::view('/docs', 'scribe.index');
});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
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
    Route::delete('types/destroy', 'TypesController@massDestroy')->name('types.massDestroy');
    Route::resource('types', 'TypesController');

    // Activities
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
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');

    // Expense Reports
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
});
