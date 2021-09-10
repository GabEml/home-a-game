<?php

use Illuminate\Support\Facades\Route;

Route::get('paiement/{id}/{sessiongames?}', 'PaymentController@show')->name('payment');
Route::post('webhook', 'WebhookController@handleWebhook')->name('webhook');
