<?php

return [
    'create_users' => false,

    'truncate_tables' => true,

    'roles_structure' => [
        'admin' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'sales' => 'c,r,u,d',
            'orders' => 'c,r,u,d',
            'pharmacy' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'pharmacy' => [
            'users' => 'r,d',
            'profile' => 'r,u',
            'orders' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'sales' => 'c,r,u,d',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
