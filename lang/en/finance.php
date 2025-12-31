<?php

return [
    'navigation' => [
        'payments' => 'Payments',
        'expenses' => 'Expenses',
    ],
    'income_categories' => [
        'fields' => [
            'name' => 'Production Number',
            'deposit' => 'Activity deposit',
        ],
    ],
    'income' => [
        'fields' => [
            'date' => 'Date',
            'user' => 'User',
            'category' => 'Category',
            'category_name' => 'Name',
            'category_deposit' => 'Deposit type',
            'amount' => 'Amount',
            'description' => 'Description',
            'payment_type' => 'Payment type',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'deleted_at' => 'Deleted at',
        ],
        'filters' => [
            'entry_date_from' => 'Entry date from',
            'entry_date_until' => 'Entry date to',
            'entry_date_from_indicator' => 'Entry date from :date',
            'entry_date_until_indicator' => 'Entry date to :date',
            'user_name' => 'Name',
        ],
    ],
    'expense_categories' => [
        'fields' => [
            'name' => 'Name',
        ],
    ],
    'expense' => [
        'fields' => [
            'date' => 'Date',
            'category' => 'Category',
            'name' => 'Name',
            'amount' => 'Amount',
            'description' => 'Description',
        ],
    ],
    'balance' => [
        'heading' => 'Balance by Member',
        'columns' => [
            'name' => 'Name',
            'payments' => 'Payments',
            'spending' => 'Activity spending',
            'balance' => 'Balance',
        ],
        'filters' => [
            'negative' => 'Negative Balance',
        ],
    ],
    'stats' => [
        'deposit' => 'Deposit',
        'activity_spending' => 'Activity spending',
    ],
    'filters' => [
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
    ],
];
