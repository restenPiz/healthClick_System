<?php

return [
    'create_users' => false,

    'truncate_tables' => true,

    'roles_structure' => [
        'admin' => [
            'users' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'payment_methods' => 'c,r,u,d',
            'orders' => 'r,u',
            'profile' => 'r,u',
        ],
        'pharmacy' => [
            'profile' => 'r,u',
            'products' => 'c,r,u,d',
            'payment_methods' => 'r',
            'orders' => 'r,u',
            'delivery' => 'c,r,u,d'
        ],
        'delivery' => [
            'profile' => 'r,u',
            'deliveries' => 'c,r,u,d',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
