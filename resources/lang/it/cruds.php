<?php

return [
    'dashboard'     => [
        'greeting' => 'Ciao ',
        'title' => 'Dashboard',
        'title_linechart' => 'Attività',
        'title_linechart_chart' => 'Attività mensile',
        'title_singular' => 'Gestione socio',
        'grantotal' => 'Saldo operativo attuale',
        'incomeAmountTotal' => 'Versamenti acconto voli',
        'activityAmountTotal' => 'Attività di volo',
        'activityHoursAndMinutes' => 'Minuti volati in totale',
        'show_all_reservations' => 'Visualizza tutte le prenotazioni',
        'personal_title' => 'Calendario prenotazioni',
        'personal_request' => 'Prenotazione',
        'slot_title' => 'Appuntamenti',
        'slot_title_singular' => 'Appuntamento',
        'book_slot' => 'Prenota ora',
        'create_request' => 'Crea richiesta',
        'edit_request' => 'Modifica richiesta',
    ],
    'userManagement'     => [
        'title'          => 'Gestione Utenti',
        'title_singular' => 'Gestione Utenti',
    ],
    'permission'         => [
        'title'          => 'Permessi',
        'title_singular' => 'Permesso',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Titolo',
            'title_helper'      => '',
            'created_at'        => 'Creato il',
            'created_at_helper' => '',
            'updated_at'        => 'Aggiornato il',
            'updated_at_helper' => '',
            'deleted_at'        => 'Cancellato il',
            'deleted_at_helper' => '',
        ],
    ],
    'role'               => [
        'title'          => 'Ruoli',
        'title_singular' => 'Ruolo',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Titolo',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Creato il',
            'created_at_helper'  => '',
            'updated_at'         => 'Aggiornato il',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Cancellato il',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'               => [
        'title'          => 'Soci',
        'title_singular' => 'Socio',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Nome',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Profilo',
            'roles_helper'             => 'Profilo del socio con relativo listino',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Creato il',
            'created_at_helper'        => '',
            'updated_at'               => 'Aggiornato il',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Cancellato il',
            'deleted_at_helper'        => '',
            'factor'                   => 'Listino prezzi',
            'factor_helper'            => 'Listino prezzi abbinato',
            'instructor'               => 'Istruttore',
            'instructor_helper'        => '',
            'medical_due' => 'Scadenza visita',
            'medical_due_helper' => 'Data di scadenza della visita medica',
            'license' => 'Licenza',
            'license_helper' => 'Matricola della licenza di volo',
            'lang' => 'Lingua',
            'lang_helper' => 'La lingua di sistema nelle comunicazioni',
            'params' => 'Parametri',
            'params_helper' => 'Parametri aggiuntivi',
            'taxno' => 'Codice fiscale',
            'taxno_helper' => '',
            'phone_1' => 'Mobile',
            'phone_1_helper' => '',
            'phone_2' => 'Telefono 2',
            'phone_2_helper' => '',
            'address' => 'Indirizzo',
            'address_helper' => '',
            'city' => 'Città',
            'city_helper' => '',
            'privacy' => 'Acconsento il trattamento dei miei dati personali',
            'plane' => 'Ratings',
            'plane_helper' => '',
        ],
    ],
    'plane'              => [
        'title'          => 'Aeroplani',
        'title_singular' => 'Aeroplano',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'callsign'          => 'Callsign',
            'callsign_helper'   => '',
            'vendor'            => 'Costruttore',
            'vendor_helper'     => '',
            'model'             => 'Modello',
            'model_helper'      => '',
            'prodno'            => 'Matricola',
            'prodno_helper'     => 'Nr. seriale o matricola',
            'created_at'        => 'Creato il',
            'created_at_helper' => '',
            'updated_at'        => 'Aggiornato il',
            'updated_at_helper' => '',
            'deleted_at'        => 'Cancellato il',
            'deleted_at_helper' => '',
            'active'            => 'Attivo',
            'active_helper'     => 'Aeroplano è operativo',
            'counter_type'      => 'Tipo di orametro',
            'counter_type_helper'      => '',
            'warmup_type'         => 'Riscaldamento a carico',
            'warmup_type_helper'  => 'Seleziona se il riscaldamento è a carico del pilota',
        ],
    ],
    'factor'             => [
        'title'          => 'Listini prezzi',
        'title_singular' => 'Listino prezzi',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'name'               => 'Nome',
            'name_helper'        => '',
            'description'        => 'Descrizione',
            'description_helper' => '',
            'created_at'         => 'Creato il',
            'created_at_helper'  => '',
            'updated_at'         => 'Aggiornato il',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Cancellato il',
            'deleted_at_helper'  => '',
        ],
    ],
    'type'               => [
        'title'          => 'Tipi di attività',
        'title_singular' => 'Tipo di attività',
        'price'          => 'Prezzo al minuto (€)',
        'title_select'   => 'Selezionare attività',
        'price'          => 'Prezzo al minuto (€)',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'name'               => 'Nome',
            'name_helper'        => '',
            'description'        => 'Descrizione',
            'description_helper' => '',
            'created_at'         => 'Creato il',
            'created_at_helper'  => '',
            'updated_at'         => 'Aggiornato il',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Cancellato il',
            'deleted_at_helper'  => '',
            'active'             => 'Attivo',
            'active_helper'      => '',
            'instructor'         => 'Attività con instruttore?',
            'instructor_helper'  => '',
        ],
    ],
    'setting'            => [
        'title'          => 'Impostazioni',
        'title_singular' => 'Impostazione',
    ],
    'activity'           => [
        'title'          => 'Attività',
        'title_singular' => 'Attività',
        'title_noedit'   => 'Informazione',
        'title_lessons' => 'Lezioni',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => '',
            'user'                  => 'Pilota',
            'user_helper'           => '',
            'plane'                 => 'Aeroplano',
            'plane_helper'          => '',
            'created_at'            => 'Creato il',
            'created_at_helper'     => '',
            'updated_at'            => 'Aggiornato il',
            'updated_at_helper'     => '',
            'deleted_at'            => 'Cancellato il',
            'deleted_at_helper'     => '',
            'type'                  => 'Tipo di attività',
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
            'rate'                  => 'Prezzo di base',
            'rate_helper'           => '',
            'minutes'               => 'Minuti',
            'minutes_helper'        => '',
            'amount'                => 'Importo',
            'amount_helper'         => '',
            'departure'             => 'Partenza',
            'departure_helper'      => '',
            'arrival'               => 'Destinazione',
            'arrival_helper'        => '',
            'event'                 => 'Data',
            'event_helper'          => '',
            'copilot'               => 'Copilota',
            'copilot_helper'        => '',
            'instructor'            => 'Istruttore',
            'instructor_helper'     => '',
            'created_by'            => 'Creato il',
            'created_by_helper'     => '',
            'opt1'                  => 'Regolare',
            'opt2'                  => 'Istruttore',
            'split_cost'            => 'Attività condivisa',
            'split_cost_helper'     => 'Il copilota è obbligatrio per dividere i costi',
            'description'           => 'Note',
            'description_helper'    => 'Note opzionali',
        ],
    ],
    'security'           => [
        'title'          => 'Sicurezza',
        'title_singular' => 'Sicurezza',
    ],
    'booking'            => [
        'title'          => 'Prenotazioni',
        'title_singular' => 'Prenotazione',
        'fields'         => [
            'id' => 'ID',
            'id_helper' => '',
            'date' => 'Data / Ora',
            'reservation_start' => 'Inizio',
            'reservation_start_helper' => 'Attenzione: Selezionare ora locale (CEST)',
            'reservation_stop' => 'Fine',
            'reservation_stop_helper' => 'Attenzione: Selezionare ora locale (CEST)',
            'description' => 'Descrizione',
            'description_helper' => '',
            'created_at' => 'Creato il',
            'created_at_helper' => '',
            'updated_at' => 'Aggiornato il',
            'updated_at_helper' => '',
            'deleted_at' => 'Cancellato il',
            'deleted_at_helper' => '',
            'user' => 'Pilota',
            'user_helper' => '',
            'plane' => 'Aeroplano',
            'plane_helper' => '',
            'instructor_needed' => 'Volo con istruttore?',
            'instructor_needed_helper' => 'Notam: Se il rating non è stato specificato si può solo prenotare con istruttore.',
            'status' => 'Status',
            'status_helper' => '',
            'mode' => 'Modalità',
            'mode_helper' => '',
            'instructor' => 'Istruttore',
            'instructor_helper' => ' ',
            'created_by' => 'Creato il',
            'created_by_helper' => '',
            'pax' => 'pax',
            'pax_helper' => ' ',
            'email' => 'Mandare email di conferma?',
            'email_helper' => 'Notam: Email di conferma verrà mandata quando selezionato.',
            'checkin' => 'Aperto al Check-In?',
            'checkin_seats' => 'Specifica massimo posti liberi',
            'checkin_helper' => 'Notam: La prenotazione diventa prenotabile per altri soci/ospiti.',
        ],
    ],
    'parameter'          => [
        'title'          => 'Parametri',
        'title_singular' => 'Parametro',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'slug'              => 'Slug',
            'slug_helper'       => '',
            'value'             => 'Value',
            'value_helper'      => '',
            'lang'              => 'Lang',
            'lang_helper'       => '',
            'created_at'        => 'Creato il',
            'created_at_helper' => '',
            'updated_at'        => 'Aggiornato il',
            'updated_at_helper' => '',
            'deleted_at'        => 'Cancellato il',
            'deleted_at_helper' => '',
        ],
    ],
    'activityManagement' => [
        'title'          => 'Gestione attività',
        'title_singular' => 'Gestione attività',
    ],
    'activityReport'     => [
        'title'          => 'Report mensile',
        'title_singular' => 'Report mensile',
        'title_generate' => 'Email socio',
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
            'activityReportTotal'        => 'Totale',
            'activityReportSummary'      => 'Resoconto',
            'activityReportByUser'       => 'Totale attività per socio',
            'activityReportByInstructor' => 'Totale attività per istruttore',
            'activityReportByType'       => 'Tipo di attività',
            'activityReportByPlane'      => 'Aeroplano',
            'activityByUser'             => 'Nome socio',
            'activityByInstructor'       => 'Nome istruttore',
            'activityByMinutes'          => 'Minuti',
            'activityTotalTime'          => 'ore:minuti',
            'amount'                     => 'Saldo',
            'totaltime'                  => 'Totale ore',
        ],
    ],
    'expenseManagement'  => [
        'title'          => 'Gestione Spese',
        'title_singular' => 'Gestione Spese',
    ],
    'expenseCategory'    => [
        'title'          => 'Categorie Spese',
        'title_singular' => 'Categoria Spese',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Nome',
            'name_helper'       => '',
            'created_at'        => 'Creato il',
            'created_at_helper' => '',
            'updated_at'        => 'Aggiornato il',
            'updated_at_helper' => '',
            'deleted_at'        => 'Cancellato il',
            'deleted_at_helper' => '',
        ],
    ],
    'incomeCategory'     => [
        'title'          => 'Categorie versamenti',
        'title_singular' => 'Categoria versamenti',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Nome',
            'name_helper'       => '',
            'created_at'        => 'Creato il',
            'created_at_helper' => '',
            'updated_at'        => 'Aggiornato il',
            'updated_at_helper' => '',
            'deleted_at'        => 'Cancellato il',
            'deleted_at_helper' => '',
            'deposit'           => 'Deposit',
            'deposit_helper'    => 'Please indicate if it is a fee or a deposit for activities',
        ],
    ],
    'expense'            => [
        'title'          => 'Spese',
        'title_singular' => 'Spesa',
        'fields'         => [
            'id'                      => 'ID',
            'id_helper'               => '',
            'expense_category'        => 'Expense Category',
            'expense_category_helper' => '',
            'entry_date'              => 'Entry Date',
            'entry_date_helper'       => '',
            'amount'                  => 'Importo',
            'amount_helper'           => '',
            'description'             => 'Descrizione',
            'description_helper'      => '',
            'created_at'              => 'Creato il',
            'created_at_helper'       => '',
            'updated_at'              => 'Aggiornato il',
            'updated_at_helper'       => '',
            'deleted_at'              => 'Cancellato il',
            'deleted_at_helper'       => '',
        ],
    ],
    'income'             => [
        'title'          => 'Versamenti',
        'title_singular' => 'Versamento',
        'fields'         => [
            'id'                     => 'ID',
            'id_helper'              => '',
            'income_category'        => 'Income Category',
            'income_category_helper' => '',
            'entry_date'             => 'Entry Date',
            'entry_date_helper'      => '',
            'amount'                 => 'Importo',
            'amount_helper'          => '',
            'description'            => 'Descrizione',
            'description_helper'     => '',
            'created_at'             => 'Creato il',
            'created_at_helper'      => '',
            'updated_at'             => 'Aggiornato il',
            'updated_at_helper'      => '',
            'deleted_at'             => 'Cancellato il',
            'deleted_at_helper'      => '',
            'user'                   => 'Member',
            'user_helper'            => '',
            'created_by'             => 'Creato il',
            'created_by_helper'      => '',
        ],
    ],
    'expenseReport'      => [
        'title'          => 'Report mensile',
        'title_singular' => 'Report mensile',
        'reports'        => [
            'title'             => 'Report',
            'title_singular'    => 'Report',
            'incomeReport'      => 'Report versamenti',
            'incomeByCategory'  => 'versamenti per categoria',
            'expenseByCategory' => 'Spese per categoria',
            'income'            => 'Versamento',
            'expense' => 'Spesa',
            'profit' => 'Profitto',
        ],
    ],
    'calendar' => [
        'title' => 'Calendario',
        'fivedays' => '+5',
        'tendays' => '10 Tage',
        'week' => 'Sett.',
        'month' => 'Mese',
    ],
    'slot' => [
        'title' => 'Tipi di slot',
        'title_singular' => 'Tipo slot',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'title' => 'Titolo',
            'title_helper' => ' ',
            'created_at' => 'Creato al',
            'created_at_helper' => ' ',
            'updated_at' => 'Modificato al',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Cancellato al',
            'deleted_at_helper' => ' ',
            'user' => 'Partecipanti',
            'user_helper' => 'Notam: Se la lista dei partecipanti è vuota, lo slot è visibile per tutti.',
            'instructor' => 'Istruttori',
            'instructor_helper' => ' ',
        ],
    ],
    'schedule' => [
        'title' => 'Prenotazioni slot',
        'title_singular' => 'Prenotazione slot',
        'fields' => [
            'user_helper' => 'Notam: Se selezioni un pilota al salvataggio lo status verrà cambiato in confermato',
            'instructor_helper' => ' ',
        ],
    ],
    'planning' => [
        'title' => 'Pianificazioni',
        'title_singular' => 'Pianificazione',
    ],
    'billing' => [
        'title' => 'Pagamenti',
        'title_singular' => 'Pagamento',
        'fields' => [
            'title' => 'Soggetto di pagamento',
            'title_helper' => ' ',
            'amount' => 'Valore',
            'amount_helper' => ' ',
        ],
    ],
    'checkout' => [
        'fields' => [
            'card-element' => 'Inserisci i dettagli della tua carta',
            'cardholder-name' => 'Intestatario',
            'card-number' => 'Numero carta',
            'card-cvc' => 'CVC',
            'card-exp' => 'Scad.',
        ],
    ],
];
