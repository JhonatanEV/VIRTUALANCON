<?php
return [
    'development' => env('VISA_TALLER_ENVIRONMENT', true),

    'credentials' => [
        'development' => [
            'merchant_id' => '522591303',
            'user' => 'integraciones.visanet@necomplus.com',
            'password' => 'd5e7nk$M',
            'url_security' => 'https://apitestenv.vnforapps.com/api.security/v1/security',
            'url_session' => 'https://apitestenv.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/522591303',
            'url_js' => 'https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true',
            'url_authorization' => 'https://apitestenv.vnforapps.com/api.authorization/v3/authorization/ecommerce/522591303',
        ],
        'production' => [
            'merchant_id' => '650250471', #COD COMERCIO PRODUCCION
            'user' => 'informatica@muniancon.gob.pe',
            'password' => '15_Fu!$X',
            'url_security' => 'https://apiprod.vnforapps.com/api.security/v1/security',
            'url_session' => 'https://apiprod.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/650250471',
            'url_js' => 'https://static-content.vnforapps.com/v2/js/checkout.js',
            'url_authorization' => 'https://apiprod.vnforapps.com/api.authorization/v3/authorization/ecommerce/650250471',
        ],
    ],

    // 'current_credentials' => function () {
    //     $environment = env('VISA_TALLER_ENVIRONMENT') ? 'development' : 'production';
    //     return config("visa_taller.credentials.{$environment}");
    // },
    
];
