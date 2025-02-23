<?php


return [
    ['title' => 'Contatos'],
    [
        'title' => 'Listar Contatos',
        'icon' => 'solar:user-id-bold',
        'route' => 'contact.show.all',
        'active_routes' => ['contact.show.all'],
    ],
    [
        'title' => 'Novo Contato',
        'icon' => 'solar:user-plus-rounded-broken',
        'route' => 'contact.create',
        'active_routes' => ['new-contac'],
    ],
    ['title' => 'Configurações'],
    [
        'title' => 'Meus Dados',
        'icon' => 'solar:settings-outline',
        'route' => 'user.show',
        'active_routes' => ['user.show'],
    ],
];
