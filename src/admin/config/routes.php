<?php
$routes = 
[
    '/'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\Auth','login'],
    ],
    '/index'=>[
        'method'=>'GET', 'POST',
        'controller'=>['Controller\Home','accueil'],
    ],
    '/login'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\Auth','login'],
    ],
    '/logout'=>[
        'method'=>'GET',
        'controller'=>['Controller\Auth','logout'],
    ],
    '/user'=>[
        'method'=>'GET',
        'controller'=>['Controller\User','index'],
    ],
    '/user/edit/{id}'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\User','edit'],
    ],
    '/user/ban/{id}'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\User','ban'],
    ],
    '/user/unban/{id}' => [
        'method' => ['POST'], 
        'controller' => ['Controller\User', 'unban'],
    ],
    '/category'=>[
        'method'=>'GET',
        'controller'=>['Controller\Cat','category'],
    ],
    '/category/add'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\Cat','addCategory'],
    ],
    '/category/edit/{id}'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\Cat','editCategory'],
    ],
    '/category/delete/{id}'=>[
        'method'=>'POST',
        'controller'=>['Controller\Cat','deleteCategory'],
    ],
];

error_log("Routes définies : " . print_r($routes, true));
