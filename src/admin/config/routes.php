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
    '/user/edit_user/{id}'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\User','edit_user'],
    ],
    '/user/ban_user/{id}'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\User','ban_user'],
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
    '/editeur'=>[
        'method'=>'GET',
        'controller'=>['Controller\editeur','editeur'],
    ],
    '/editeur/edit_editeur/{id}'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\editeur','edit_editeur'],
    ],
    '/editeur/add'=>[
        'method'=>['GET', 'POST'],
        'controller'=>['Controller\editeur','addEditeur'],
    ],
    '/editeur/delete/{id}'=>[
        'method'=>'POST',
        'controller'=>['Controller\editeur','deleteEditeur'],
    ],
];

error_log("Routes définies : " . print_r($routes, true));
