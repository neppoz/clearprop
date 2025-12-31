<?php

return [
    'navigation' => [
        'payments' => 'Pagamenti',
        'expenses' => 'Spese',
    ],
    'income_categories' => [
        'fields' => [
            'name' => 'Numero di produzione',
            'deposit' => 'Deposito attività',
        ],
    ],
    'income' => [
        'fields' => [
            'date' => 'Data',
            'user' => 'Utente',
            'category' => 'Categoria',
            'category_name' => 'Nome',
            'category_deposit' => 'Tipo di deposito',
            'amount' => 'Importo',
            'description' => 'Descrizione',
            'payment_type' => 'Tipo di pagamento',
            'created_at' => 'Creato il',
            'updated_at' => 'Aggiornato il',
            'deleted_at' => 'Eliminato il',
        ],
        'filters' => [
            'entry_date_from' => 'Data registrazione dal',
            'entry_date_until' => 'Data registrazione al',
            'entry_date_from_indicator' => 'Data registrazione dal :date',
            'entry_date_until_indicator' => 'Data registrazione al :date',
            'user_name' => 'Nome',
        ],
    ],
    'expense_categories' => [
        'fields' => [
            'name' => 'Nome',
        ],
    ],
    'expense' => [
        'fields' => [
            'date' => 'Data',
            'category' => 'Categoria',
            'name' => 'Nome',
            'amount' => 'Importo',
            'description' => 'Descrizione',
        ],
    ],
    'balance' => [
        'heading' => 'Saldo per membro',
        'columns' => [
            'name' => 'Nome',
            'payments' => 'Pagamenti',
            'spending' => 'Spesa attività',
            'balance' => 'Saldo',
        ],
        'filters' => [
            'negative' => 'Saldo negativo',
        ],
    ],
    'stats' => [
        'deposit' => 'Depositi',
        'activity_spending' => 'Spesa attività',
    ],
    'filters' => [
        'start_date' => 'Data inizio',
        'end_date' => 'Data fine',
    ],
];
