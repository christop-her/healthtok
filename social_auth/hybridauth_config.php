<?php
return [
    'callback' => "https://healthtok.onrender.com//social_auth/callback.php?provider=" . htmlspecialchars($_GET['provider']), // Your callback URL

    'providers' => [
        'Google' => [
            'enabled' => true,
            'keys'    => [
                'id' => '437282564551-r7hb1tct8jihu7sef9j9bjal10qim689.apps.googleusercontent.com', // Google client ID
                'secret' => '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' // Google client secret
            ],
            'scope'   => 'email profile', // Optional
        ],

        'Facebook' => [
            'enabled' => true,
            'keys'    => [
                'id' => '914531290597121', // Facebook app ID
                'secret' => 'e3f1050f7e8ca410b2f3b6b8c2345b38' // Facebook app secret
            ],
            'scope'   => 'email, public_profile', // Optional
        ],
    ],
];