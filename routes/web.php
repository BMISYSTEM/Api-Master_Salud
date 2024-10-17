<?php

use Illuminate\Support\Facades\Route;

Route::get('/compra', function () {
    return view('emails.compra');
});
