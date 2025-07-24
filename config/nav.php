<?php

return [
    [
        'icon' => 'fas fa-tachometer-alt',
        'title' => 'Dashboard',
        'route' => 'dashboard.index',
        'active' => 'dashboard',
        'ability' => 'dashboard.view',
    ],
    [
        'icon' => 'fas fa-tags',
        'title' => 'Categories',
        'route' => 'dashboard.categories.index',
        'active' => 'dashboard.categories.*',
        'ability' => 'categories.view',
    ],
    [
        'icon' => 'fas fa-box',
        'title' => 'Products',
        'route' => 'dashboard.products.index',
        'active' => 'dashboard.products.*',
        'badge' => 'new',
        'ability' => 'products.view',
    ],
    [
        'icon' => 'fas fa-user-shield',
        'title' => 'Roles',
        'route' => 'dashboard.roles.index',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.view',
    ],
    [
        'icon' => 'fas fa-user',
        'title' => 'Users',
        'route' => 'dashboard.users.index',
        'active' => 'dashboard.users.*',
        'ability' => 'users.view',
    ],
    [
        'icon' => 'fas fa-user-cog',
        'title' => 'Admins',
        'route' => 'dashboard.admins.index',
        'active' => 'dashboard.admins.*',
        'ability' => 'admins.view',
    ]
];
