<?php

return [

	/*
    |--------------------------------------------------------------------------
    | Enviroment
    |--------------------------------------------------------------------------
    |
    | Please provide the enviroment you would like to use for braintree.
    | This can be either 'sandbox' or 'production'.
    |
    */
	'environment' => env('BRAINTREE_ENVIRONMENT', 'sandbox'),

	/*
    |--------------------------------------------------------------------------
    | Merchant ID
    |--------------------------------------------------------------------------
    |
    | Please provide your Merchant ID.
    |
    */
	'merchantId' => env('BRAINTREE_MERCHANT_ID'),

	/*
    |--------------------------------------------------------------------------
    | Public Key
    |--------------------------------------------------------------------------
    |
    | Please provide your Public Key.
    |
    */
	'publicKey' => env('BRAINTREE_PUBLIC_KEY'),

	/*
    |--------------------------------------------------------------------------
    | Private Key
    |--------------------------------------------------------------------------
    |
    | Please provide your Private Key.
    |
    */
	'privateKey' => env('BRAINTREE_PRIVATE_KEY'),

	/*
    |--------------------------------------------------------------------------
    | Client Side Encryption Key
    |--------------------------------------------------------------------------
    |
    | Please provide your CSE Key.
    |
    */
	'clientSideEncryptionKey' => env('BRAINTREE_CLIENT_ENCRYPTION_KEY'),
	
];