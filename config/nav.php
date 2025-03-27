<?php
return[
    [
        'icon'=>'nav-icon fas fa-tachometer-alt',
        'route'=>'dashboard',
        'title'=>'dashboard',
        'active'=>'dashboard'
        ] ,
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'categories.index',
        'title'=>'categories',
        'active'=>'categories.index'
        ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'products.index',
        'title'=>'products',
        'active'=>'products.index'
        ],
    [
        'icon'=>'far fa-circle nav-icon ',
        'route'=>'dashboard',
        'title'=>'orders',
        'badge'=>'new',
        'active'=>'dashboard.orders*'
        ]

];
