<?php
return [
    'development' => env('VISA_ENVIRONMENT', true),

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
            'merchant_id' => env('NIUBIZ_MERCHANT_ID'), #COD_COMERCIO PRODUCCION
            'user' => env('NIUBIZ_USER'), #USUARIO
            'password' => env('NIUBIZ_PASSWORD'), #CLAVE
            'url_security' => 'https://apiprod.vnforapps.com/api.security/v1/security',
            'url_session' => 'https://apiprod.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/'.env('NIUBIZ_MERCHANT_ID'), #COD_COMERCIO
            'url_js' => 'https://static-content.vnforapps.com/v2/js/checkout.js',
            'url_authorization' => 'https://apiprod.vnforapps.com/api.authorization/v3/authorization/ecommerce/'.env('NIUBIZ_MERCHANT_ID'), #COD_COMERCIO
        ],
    ],

    // 'current_credentials' => function () {
    //     $environment = env('VISA_ENVIRONMENT') ? 'development' : 'production';
    //     return config("visa.credentials.{$environment}");
    // },
    
];
