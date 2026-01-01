<?php

return [
    'navigation' => [
        'singular' => 'Asset',
        'plural' => 'Assets',
    ],
    'navigation_group' => 'Gestione',
    'labels' => [
        'singular' => 'Asset',
        'plural' => 'Assets',
    ],
    'sections' => [
        'general' => 'Informazioni Generali',
        'lifecycle' => 'Ciclo di Vita',
        'assignment' => 'Assegnazione',
        'service' => 'Intervallo di Manutenzione',
    ],
    'fields' => [
        'name' => 'Nome',
        'serial_number' => 'Numero di Serie',
        'category' => 'Categoria',
        'plane' => 'Aeromobile',
        'status' => 'Stato',
        'assigned_to' => 'Assegnato a',
        'start_date' => 'Data Inizio',
        'end_date' => 'Data Fine',
        'start_hours' => 'Ore Inizio',
        'end_hours' => 'Ore Fine',
        'current_running_hours' => 'Ore di Funzionamento Attuali',
        'service_interval_hours' => 'Intervallo di Manutenzione',
        'last_service_hours' => 'Ultima Manutenzione a',
        'last_service_date' => 'Data Ultima Manutenzione',
        'service_status' => 'Stato Manutenzione',
        'hours_until_service' => 'Ore alla Manutenzione',
        'notes' => 'Note',
        'created_at' => 'Creato il',
        'updated_at' => 'Aggiornato il',
    ],

    'service' => [
        'overdue' => 'Scaduto',
        'due_soon' => 'In Scadenza',
        'ok' => 'OK',
    ],

    'categories' => [
        'propeller' => 'Elica',
        'engine' => 'Motore',
        'airframe' => 'Cellula',
        'advanced' => 'Avanzato',
    ],

    'statuses' => [
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'broken' => 'Rotto',
        'out_for_repair' => 'In Riparazione',
    ],
];
