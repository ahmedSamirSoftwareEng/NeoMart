<?php

return [
    [
        'icon' => 'right fas fa-angle-left',
        'title' => 'Dashboard',
        'route' => 'dashboard.index',
        'active' => 'dashboard',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'title' => 'Categories',
        'route' => 'dashboard.categories.index',
        'badge' => 'new',
        'active' => 'dashboard.categories.*',
    ],
   

];
