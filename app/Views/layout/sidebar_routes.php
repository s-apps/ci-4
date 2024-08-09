<?php

$uri = service('uri'); 

$routes = [
    [
        'label' => 'Painel de controle',
        'icon'  => 'cil-speedometer',
        'href'  => '/',
        'active' => $uri->getSegment(1) === '' ? 'active' : '',
        'subgroup' => []
    ],
    [
        'label' => 'Cadastros',
        'icon'  => 'cil-folder',
        'show'  => $uri->getSegment(1) === 'register' ? 'show' : '',
        'expanded' => $uri->getSegment(1) === 'register' ? 'true' : 'false',
        'subgroup' => [
            [
                'label' => 'Clientes',
                'href'  => 'register/customer',
                'active' => $uri->getSegment(1) === 'register' && $uri->getSegment(2) === 'customer' ? 'active' : ''
            ],
            [
                'label' => 'Embalagens',
                'href'  => 'register/package',
                'active' => $uri->getSegment(1) === 'register' && $uri->getSegment(2) === 'package' ? 'active' : ''

            ],
            [
                'label' => 'Produtos',
                'href'  => 'register/product',
                'active' => $uri->getSegment(1) === 'register' && $uri->getSegment(2) === 'product' ? 'active' : ''
            ]
        ]
    ],
    [
        'label' => 'Relatórios',
        'icon'  => 'cil-notes',
        'show'  => $uri->getSegment(1) === 'report' ? 'show' : '',
        'expanded'  => $uri->getSegment(1) === 'report' ? 'true' : 'false',
        'subgroup' => [
            [
                'label' => 'Clientes',
                'href'  => 'report/customer',
                'active' => $uri->getSegment(1) === 'report' && $uri->getSegment(2) === 'customer' ? 'active' : ''

            ],
            [
                'label' => 'Embalagens',
                'href'  => 'report/package',
                'active' => $uri->getSegment(1) === 'report' && $uri->getSegment(2) === 'package' ? 'active' : ''
            ],
            [
                'label' => 'Pedidos',
                'href'  => 'report/order',
                'active' => $uri->getSegment(1) === 'report' && $uri->getSegment(2) === 'order' ? 'active' : ''
            ],
            [
                'label' => 'Produtos',
                'href'  => 'report/product',
                'active' => $uri->getSegment(1) === 'report' && $uri->getSegment(2) === 'product' ? 'active' : ''
            ]
        ]
    ],
    [
        'label' => 'Pedidos',
        'icon'  => 'cil-cart',
        'href'  => 'order',
        'active' => $uri->getSegment(1) === 'order' ? 'active' : '',
        'subgroup' => []
    ],
    [
        'label' => 'Sair',
        'icon'  => 'cil-exit-to-app',
        'href'  => 'logout',
        'active'   => '',
        'subgroup' => []
    ]
];