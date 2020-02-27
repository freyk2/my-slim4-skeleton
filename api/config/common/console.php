<?php

use App\Console;

return [
    'config' => [
        'console' => [
            'commands' => [
                Console\User\CreateAdminCommand::class,
            ],
        ],
    ],
];
