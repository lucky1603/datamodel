<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


Mail::raw('Ovo je proba slanja!!!', function ($message) {
    $message->to('sinisa.ristic@prosmart.rs')->subject('Test mail');
});
