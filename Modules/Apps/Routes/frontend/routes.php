<?php

Route::get('/', function (){
    return redirect(route('dashboard.home'));
})->name('frontend.home');
