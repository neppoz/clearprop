<?php

return [
    'navigation' => [
        'singular' => 'Asset',
        'plural' => 'Assets',
    ],
    'navigation_group' => 'Management',
    'labels' => [
        'singular' => 'Asset',
        'plural' => 'Assets',
    ],
    'sections' => [
        'general' => 'General Information',
        'lifecycle' => 'Lifecycle',
        'assignment' => 'Assignment',
        'service' => 'Service Interval',
    ],
    'fields' => [
        'name' => 'Name',
        'serial_number' => 'Serial Number',
        'category' => 'Category',
        'plane' => 'Aircraft',
        'status' => 'Status',
        'assigned_to' => 'Assigned To',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'start_hours' => 'Start Hours',
        'end_hours' => 'End Hours',
        'current_running_hours' => 'Current Running Hours',
        'service_interval_hours' => 'Service Interval',
        'last_service_hours' => 'Last Service at',
        'last_service_date' => 'Last Service Date',
        'service_status' => 'Service Status',
        'hours_until_service' => 'Hours until Service',
        'notes' => 'Notes',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],

    'service' => [
        'overdue' => 'Overdue',
        'due_soon' => 'Due Soon',
        'ok' => 'OK',
    ],

    'categories' => [
        'propeller' => 'Propeller',
        'engine' => 'Engine',
        'airframe' => 'Airframe',
        'advanced' => 'Advanced',
    ],

    'statuses' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'broken' => 'Broken',
        'out_for_repair' => 'Out for Repair',
    ],
];
