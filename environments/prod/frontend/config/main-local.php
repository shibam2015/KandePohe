<?php
return [
    'components' => [
        'urlManager'   => require('url-rules-local.php'),
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/themes/kande_pohe'],
                'baseUrl' => '@web',
            ],
        ],
    ],
];
