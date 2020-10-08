<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Dashboard
    Route::get('/stats', 'DashboardApiController@stats');
    Route::get('/currentUser', 'DashboardApiController@currentUser');

    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Planes
    Route::apiResource('planes', 'PlanesApiController');

    // Factors
    Route::apiResource('factors', 'FactorsApiController');

    // Types
    Route::apiResource('types', 'TypesApiController');

    // Activities
    Route::apiResource('activities', 'ActivitiesApiController');

    // Bookings
    Route::get('bookings/{from_date?}/{to_date?}', 'BookingsApiController@index');
    Route::get('bookings/personal/{user_id}/{from_date?}/{to_date?}', 'BookingsApiController@personal');
    Route::apiResource('bookings', 'BookingsApiController');

    // Parameters
    Route::apiResource('parameters', 'ParametersApiController');

    // Expense Categories
    Route::apiResource('expense-categories', 'ExpenseCategoryApiController');

    // Income Categories
    Route::apiResource('income-categories', 'IncomeCategoryApiController');

    // Expenses
    Route::apiResource('expenses', 'ExpenseApiController');

    // Incomes
    Route::apiResource('incomes', 'IncomeApiController');

    // Ratings
    Route::get('ratings/{user_id}/{plane_id}', 'RatingsApiController@index');
});
