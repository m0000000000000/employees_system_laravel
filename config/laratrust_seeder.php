<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'users' => 'c,r,u,d',
            'countries' => 'c,r,u,d',
            'states' => 'c,r,u,d',
            'cities' => 'c,r,u,d',
            'employees' => 'c,r,u,d',
            'departments' => 'c,r,u,d'
        ],
        'admin' => [
//            'users' => 'c,r,u,d',
//            'profile' => 'r,u'
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
