<?php

return [
    'navigation' => [
        'singular' => 'Utente',
        'plural' => 'Utenti',
    ],
    'navigation_group' => 'Gestione',

    'sections' => [
        'profile' => 'Informazioni personali',
        'profile_description' => 'Aggiorna i tuoi dati personali e di contatto.',
        'login' => 'Credenziali di accesso',
        'password' => 'Modifica password',
        'password_description' => 'Assicurati di utilizzare una password lunga e sicura.',
        'contact' => 'Dati di contatto',
        'access' => 'Autorizzazioni',
        'verification' => 'Verifica',
        'timestamps' => 'Cronologia',
    ],

    'fields' => [
        'name' => 'Nome',
        'email' => 'Email (Login)',
        'password' => 'Nuova password',
        'current_password' => 'Password attuale',
        'password_confirmation' => 'Conferma password',
        'medical_due' => 'Scadenza certificato medico',
        'license' => 'Licenza',
        'phone_1' => 'Telefono (Cellulare)',
        'phone_2' => 'Telefono (Lavoro)',
        'address' => 'Indirizzo',
        'city' => 'Città',
        'taxno' => 'Partita IVA',
        'email_verified_at' => 'Email verificata',
        'privacy_confirmed_at' => 'Privacy confermata',
        'role' => 'Livello di accesso',
        'created_at' => 'Creato il',
        'updated_at' => 'Ultima modifica',
    ],

    'helper' => [
        'email' => 'Questo è anche l\'indirizzo email per il login.',
        'email_fixed' => 'Questa è la tua email di login e non può essere modificata.',
        'role' => 'Seleziona il ruolo da assegnare all\'utente.',
        'email_verified_at' => 'Attiva per segnare l\'email come verificata.',
    ],

    'notifications' => [
        'profile_updated' => 'Profilo aggiornato con successo.',
        'password_updated' => 'Password aggiornata con successo.',
        'email_settings_missing_title' => 'Impostazioni email mancanti',
        'email_settings_missing_body' => 'Configura le impostazioni email nella pagina dedicata.',
        'invitation_error_title' => 'Errore invito',
        'invitation_existing' => 'Esiste già un utente con questa email.',
        'invitation_existing_deleted' => 'Esiste già un utente con questa email ma è stato eliminato.',
        'invited_success_title' => 'Invito inviato',
        'invited_success_body' => 'Utente invitato con successo!',
        'email_sending_failed_title' => 'Invio email fallito',
        'email_sending_failed_body' => 'Errore nell\'invio dell\'email. Controlla la configurazione email.',
        'unexpected_error_title' => 'Errore imprevisto',
        'unexpected_error_body' => 'Si è verificato un errore imprevisto durante l\'invio. Riprova più tardi.',
    ],

    'actions' => [
        'save_profile' => 'Salva profilo',
        'save_password' => 'Aggiorna password',
        'create' => 'Crea utente',
        'send_invitation' => 'Invia invito',
    ],

    'table' => [
        'email' => 'Indirizzo email',
        'mobile' => 'Cellulare',
        'office' => 'Lavoro',
        'roles' => 'Ruoli',
    ],
];
