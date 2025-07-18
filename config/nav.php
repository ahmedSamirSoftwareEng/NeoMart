<?php

return [
    [
        'icon' => 'right fas fa-angle-left',
        'title' => 'Dashboard',
        'route' => 'dashboard.index',
        'active' => 'dashboard',
        'ability' => 'dashboard.view',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'title' => 'Categories',
        'route' => 'dashboard.categories.index',
        'active' => 'dashboard.categories.*',
        'ability' => 'categories.view',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'title' => 'Products',
        'route' => 'dashboard.products.index',
        'active' => 'dashboard.products.*',
        'badge' => 'new',
        'ability' => 'products.view',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'title' => 'Roles',
        'route' => 'dashboard.roles.index',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.view',
    ]


];
