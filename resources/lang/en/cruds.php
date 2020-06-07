<?php

return [
    'dashboard'     => [
        'title' => 'Dashboard',
        'title_linechart'=> 'Activities',
        'title_linechart_chart'=> 'Monthly total',
        'title_singular' => 'Member management',
    ],
    'userManagement'     => [
        'title'          => 'Member management',
        'title_singular' => 'Member management',
    ],
    'permission'         => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'               => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'               => [
        'title'          => 'Members',
        'title_singular' => 'Member',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
            'factor'                   => 'Price List',
            'factor_helper'            => 'Price List assigned to the member',
            'instructor'               => 'Instructor',
            'instructor_helper'        => '',
            'medical_due'              => 'Medical',
            'medical_due_helper'       => '',
            'license'                  => 'License',
            'license_helper'           => '',
            'lang'                     => 'Language',
            'lang_helper'              => 'The language setting for the member',
        ],
    ],
    'plane'              => [
        'title'          => 'Planes',
        'title_singular' => 'Plane',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'callsign'          => 'Callsign',
            'callsign_helper'   => '',
            'vendor'            => 'Vendor',
            'vendor_helper'     => '',
            'model'             => 'Model',
            'model_helper'      => '',
            'prodno'            => 'Product No.',
            'prodno_helper'     => 'Serial or product number',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'active'            => 'Active',
            'active_helper'     => 'Plane is operational',
        ],
    ],
    'factor'             => [
        'title'          => 'Memberships',
        'title_singular' => 'Membership',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'name'               => 'Name',
            'name_helper'        => '',
            'description'        => 'Description',
            'description_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'type'               => [
        'title'          => 'Activity Types',
        'title_singular' => 'Activity Type',
        'price'          => 'Price per minute (€)',
        'title_select'   => 'Please select activity',
        'price'          => 'Price per minute (€)',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'name'               => 'Name',
            'name_helper'        => '',
            'description'        => 'Description',
            'description_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
            'active'             => 'Active',
            'active_helper'      => '',
            'instructor'         => 'Lesson with instructor?',
            'instructor_helper'  => '',
        ],
    ],
    'setting'            => [
        'title'          => 'Settings',
        'title_singular' => 'Setting',
    ],
    'activity'           => [
        'title'          => 'Activities',
        'title_singular' => 'Activity',
        'title_noedit'   => 'Information',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => '',
            'user'                  => 'Pilot',
            'user_helper'           => '',
            'plane'                 => 'Plane',
            'plane_helper'          => '',
            'created_at'            => 'Created at',
            'created_at_helper'     => '',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => '',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => '',
            'type'                  => 'Activity Type',
            'type_helper'           => '',
            'event_start'           => 'Event Start',
            'event_start_helper'    => '',
            'event_stop'            => 'Event Stop',
            'event_stop_helper'     => '',
            'engine_warmup'         => 'Engine Warmup',
            'engine_warmup_helper'  => '',
            'warmup_start'          => 'Warmup Start',
            'warmup_start_helper'   => '',
            'counter_start'         => 'Counter Start',
            'counter_start_helper'  => '',
            'counter_stop'          => 'Counter Stop',
            'counter_stop_helper'   => '',
            'warmup_minutes'        => 'Warmup Minutes',
            'warmup_minutes_helper' => '',
            'rate'                  => 'Calculated price',
            'rate_helper'           => '',
            'minutes'               => 'Minutes',
            'minutes_helper'        => '',
            'amount'                => 'Amount',
            'amount_helper'         => '',
            'departure'             => 'Departure',
            'departure_helper'      => '',
            'arrival'               => 'Arrival',
            'arrival_helper'        => '',
            'event'                 => 'Date',
            'event_helper'          => '',
            'copilot'               => 'Copilot',
            'copilot_helper'        => '',
            'instructor'            => 'Instructor',
            'instructor_helper'     => '',
            'created_by'            => 'Created By',
            'created_by_helper'     => '',
            'opt1'                  => 'Regular',
            'opt2'                  => 'Instructor',
            'split_cost'            => 'Split activity',
            'split_cost_helper'     => 'Copilot must be set when registering',
            'description'           => 'Notes',
            'description_helper'    => 'Optional notes',
        ],
    ],
    'security'           => [
        'title'          => 'Security',
        'title_singular' => 'Security',
    ],
    'booking'            => [
        'title'          => 'Bookings',
        'title_singular' => 'Booking',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'reservation_start'        => 'Reservation Start',
            'reservation_start_helper' => '',
            'reservation_stop'         => 'Reservation Stop',
            'reservation_stop_helper'  => '',
            'description'              => 'Description',
            'description_helper'       => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
            'user'                     => 'Pilot',
            'user_helper'              => '',
            'plane'                    => 'Plane',
            'plane_helper'             => '',
            'created_by'               => 'Created By',
            'created_by_helper'        => '',
        ],
    ],
    'parameter'          => [
        'title'          => 'Parameters',
        'title_singular' => 'Parameter',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'slug'              => 'Slug',
            'slug_helper'       => '',
            'value'             => 'Value',
            'value_helper'      => '',
            'lang'              => 'Lang',
            'lang_helper'       => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'activityManagement' => [
        'title'          => 'Activity Management',
        'title_singular' => 'Activity Management',
    ],
    'activityReport'     => [
        'title'          => 'Activity report',
        'title_singular' => 'Activity report',
        'title_generate' => 'Member Email',
        'fields'         => [
            'activityfrom'          => 'from',
            'activityfrom_helper'   => 'Begin report',
            'activityuntil'         => 'until',
            'activityto_helper'     => 'End report',
            'reportname'            => 'Name of the report',
            'reportname_helper'     => 'Ex.: 2020-02-01_Reportname_Pilotname',
            'generateReport'        => 'Send email',
        ],
        'reports'         => [
            'activityReportTotal'     => 'Total',
            'activityReportSummary'   => 'Overview',
            'activityReportByUser'    => 'Total activities by member',
            'activityReportByType'    => 'Activity type',
            'activityReportByPlane'   => 'Plane type',
            'activityByUser'          => 'Member Name',
            'activityByMinutes'       => 'minutes',
            'activityTotalTime'       => 'hours:minutes',
            'amount'   =>'Total Amount',
            'totaltime'   =>'Total Hours',
        ],
    ],
    'expenseManagement'  => [
        'title'          => 'Finance Management',
        'title_singular' => 'Finance Management',
    ],
    'expenseCategory'    => [
        'title'          => 'Expense Categories',
        'title_singular' => 'Expense Category',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated At',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted At',
            'deleted_at_helper' => '',
        ],
    ],
    'incomeCategory'     => [
        'title'          => 'Income categories',
        'title_singular' => 'Income Category',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated At',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted At',
            'deleted_at_helper' => '',
            'deposit'           => 'Type',
            'deposit_helper'    => 'Please indicate if it is a fee or a deposit for activities',
        ],
    ],
    'expense'            => [
        'title'          => 'Expenses',
        'title_singular' => 'Expense',
        'fields'         => [
            'id'                      => 'ID',
            'id_helper'               => '',
            'expense_category'        => 'Expense Category',
            'expense_category_helper' => '',
            'entry_date'              => 'Entry Date',
            'entry_date_helper'       => '',
            'amount'                  => 'Amount',
            'amount_helper'           => '',
            'description'             => 'Description',
            'description_helper'      => '',
            'created_at'              => 'Created at',
            'created_at_helper'       => '',
            'updated_at'              => 'Updated At',
            'updated_at_helper'       => '',
            'deleted_at'              => 'Deleted At',
            'deleted_at_helper'       => '',
        ],
    ],
    'income'             => [
        'title'          => 'Income',
        'title_singular' => 'Income',
        'fields'         => [
            'id'                     => 'ID',
            'id_helper'              => '',
            'income_category'        => 'Income Category',
            'income_category_helper' => '',
            'entry_date'             => 'Entry Date',
            'entry_date_helper'      => '',
            'amount'                 => 'Amount',
            'amount_helper'          => '',
            'description'            => 'Description',
            'description_helper'     => '',
            'created_at'             => 'Created at',
            'created_at_helper'      => '',
            'updated_at'             => 'Updated At',
            'updated_at_helper'      => '',
            'deleted_at'             => 'Deleted At',
            'deleted_at_helper'      => '',
            'user'                   => 'Member',
            'user_helper'            => '',
            'created_by'             => 'Created By',
            'created_by_helper'      => '',
        ],
    ],
    'expenseReport'      => [
        'title'          => 'Finance report',
        'title_singular' => 'Finance report',
        'reports'        => [
            'title'             => 'Reports',
            'title_singular'    => 'Report',
            'incomeReport'      => 'Incomes report',
            'incomeByCategory'  => 'Income by category',
            'expenseByCategory' => 'Expense by category',
            'income'            => 'Income',
            'expense'           => 'Expense',
            'profit'            => 'Profit',
            'membername'        => 'Member',
            'sumactivity'       => 'Activities(€)',
            'sumincome'         => 'Deposits(€)',
            'sumtotal'         => 'Balance(€)',
        ],
    ],
];
