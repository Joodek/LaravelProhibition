<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Model class
    |--------------------------------------------------------------------------
    |
    | This option configure the model will be banned,
    |
    */
    "model" => \App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Restrict mode
    |--------------------------------------------------------------------------
    |
    | This option configure wether to block the banned users or not
    |
    */
    "restrict" => true,

    /*
    |--------------------------------------------------------------------------
    | Response error
    |--------------------------------------------------------------------------
    |
    | This option configure the response error will be returened to
    | banned users
    |
    */
    "error" => [
        "code" => 403,
        "message" => "Forbidden !"
    ]
];
