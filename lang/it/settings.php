<?php

return [
    'general' => [
        'navigation_label' => 'Impostazioni generali',
        'navigation_group' => 'Impostazioni',
        'title' => 'Impostazioni generali',
        'sections' => [
            'reservations' => 'Prenotazioni',
        ],
        'fields' => [
            'check_medical' => 'Verifica validità medica',
            'check_medical_helper' => 'Controlla la validità medica per le prenotazioni',
            'check_airworthiness' => 'Verifica aeronavigabilità',
            'check_airworthiness_helper' => 'Controlla l\'aeronavigabilità per le prenotazioni',
            'airworthiness_limit_days' => 'Limite aeronavigabilità (giorni)',
            'check_balance' => 'Verifica disponibilità',
            'check_balance_helper' => 'Controlla i fondi del PIC per le prenotazioni',
            'balance_limit_amount' => 'Saldo minimo richiesto',
        ],
        'suffixes' => [
            'days' => 'giorni',
        ],
    ],
    'email' => [
        'navigation_label' => 'Impostazioni email',
        'navigation_group' => 'Impostazioni',
        'title' => 'Impostazioni email',
        'fields' => [
            'smtp_host' => 'Host SMTP',
            'smtp_host_helper' => 'Inserisci un hostname valido, es. smtp.example.com',
            'smtp_port' => 'Porta SMTP',
            'smtp_port_helper' => 'Es. 587 (TLS), 465 (SSL) o 25 (nessuna)',
            'smtp_username' => 'Username SMTP',
            'smtp_password' => 'Password SMTP',
            'from_address' => 'Indirizzo mittente',
            'from_name' => 'Nome mittente',
            'allow_self_signed' => 'Consenti connessione non sicura',
            'allow_self_signed_helper' => 'Disattiva la verifica del certificato. Usa solo in caso di errori TLS/SSL.',
            'test_recipient' => 'Email destinatario',
            'test_recipient_placeholder' => 'Inserisci un indirizzo email valido',
        ],
        'actions' => [
            'save' => 'Salva',
            'save_and_test' => 'Salva e testa',
            'modal_heading' => 'Inserisci email di test',
            'modal_submit' => 'Invia email di test',
        ],
        'notifications' => [
            'saved_title' => 'Impostazioni salvate',
            'saved_body' => 'Le impostazioni email sono state salvate correttamente.',
            'invalid_email_title' => 'Indirizzo email non valido',
            'invalid_email_body' => 'Inserisci un indirizzo email valido.',
            'test_sent_title' => 'Email di test inviata!',
            'test_sent_body' => 'L\'email è stata inviata correttamente!',
            'smtp_error_title' => 'Errore connessione SMTP',
            'smtp_error_body' => 'Connessione al server mail non riuscita. Controlla le impostazioni SMTP: :message',
            'generic_error_title' => 'Errore',
            'generic_error_body' => 'Impossibile inviare l\'email di test: :message',
        ],
    ],
];
