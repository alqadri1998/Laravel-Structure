<?php

return [

    "login" => [
        "email*" => "string",
        "password*" => "string",
        "fcm_token*" => "string"
    ],

    "register" => [
        "full_name*" => "string",
        "email*" => "string",
        "phone*" => "string",
        "gender" => "string",
        "verify_with" => "string",
        "password*" => "string",
        "password_confirmation" => "string",
        "fcm_token" => "string"
    ],

    "update_profile" => [
        "full_name*" => "string",
        "email*" => "string",
        "phone*" => "string",
        "gender" => "string",
        "about" => "string",
        "address" => "string",
        "location" => "array(longitude,latitude)"
    ],

    "verify-phone" => [
        "verification_code*" => "string"
    ],

    "email_verification" => [
        "verification_code*" => "string"
    ],

    "change_password" => [
        "current_password*" => "string",
        "password*" => "string",
        "password_confirmation*" => "string"
    ],

    "send_reset_email" => [
        'email*' => 'string'
    ],

    "reset_password" => [
        'verification_code*' => 'string',
        'email*' => 'string',
        'password*' => 'string',
        'password_confirmation*' => 'string',
    ],

    "contact-us" => [
        'full_name' => "string",
        'email' => "string",
        'phone' => "string",
        'message' => "string",
    ],

    "company-detail" => [
        'company_id*' => 'int'
    ],

    "company-listing" => [
        'brand' => 'int',
        'min_price' => 'int',
        'max_price' => 'int',
        'sort_by' => 'string'
    ],

    "update-company" => [
        'user_id*' => 'int',
        'company_id*' => 'int',
        'type*' => 'string',
        'address*' => 'string',
        'latitude*' => 'double',
        'longitude*' => 'double',
        'contact_number*' => 'string',
        'email*' => 'string',
        'title*' => 'string',
        'short_detail*' => 'string',
        'detail*' => 'string',
        'timing' => 'array(day, stat_time, end_time, off)'
    ],

    "create-company" => [
        'user_id*' => 'int',
        'image*' => 'string',
        'company_id*' => 'int',
        'type*' => 'string',
        'address*' => 'string',
        'latitude*' => 'double',
        'longitude*' => 'double',
        'contact_number*' => 'string',
        'email*' => 'string',
        'title*' => 'string',
        'short_detail*' => 'string',
        'detail*' => 'string',
        'timing' => 'array(day, stat_time, end_time, off)'
    ],

    "cars" => [
        'brand_id*' => 'int',
        'rent_perday*' => 'string',
        'average_rating*' => 'string',
        'security_amount*' => 'string',
        'title*' => 'string',
        'detail*' => 'string',
        'fuel_policy*' => 'string',
        'image' => 'string'
    ]
    
    

];