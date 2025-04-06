<?php

use App\Livewire\AcceptInvitation;

Route::redirect('/', '/panel/login');

Route::get('/login', fn() => redirect('/panel/login'))->name('login');

Route::middleware('signed')
    ->get('invitation/{invitation}/accept', AcceptInvitation::class)
    ->name('invitation.accept');

