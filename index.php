<?php
return [
    'name' => 'medusa',

    'autoload' => [
        'GreenCheap\\Medusa\\' => 'src'
    ],

    'routes' => [
        '/api/medusa' => [
            'name' => '@api/medusa',
            'controller' => [
                'GreenCheap\\Medusa\\Controller\\ApiMedusaController'
            ]
        ]
    ],

    'menus' => [
        'main' => 'Main',
        'second' => 'Second',
        'others' => 'Others'
    ],

    'positions' => [
        'navbar' => 'Navbar Items',
        'navbar-vertical' => 'Navbar Vertical',
        'top' => 'Top',
        'sidebar' => 'Sidebar',
        'bottom' => 'Bottom',
        'footer' => 'Footer'
    ],

    'node' => [
        'section' => 'uk-section uk-section-default',
        'container' => 'uk-container',
        'sectionSize' => '',
        'sectionImage' => '',
        'contentAlign' => '',
        'titleHide' => false,
        'titleDomElement' => 'h1',
        'titleColor' => '',
        'titleClass' => ''
    ],

    'widget' => [
        'onHeightViewport' => false,
        'heights' => [
            'offset-bottom' => 20,
            'offset-top' => 0 
        ],
        'section' => 'uk-section uk-section-default',
        'sectionSize' => '',
        'sectionImage' => '',
        'contentAlign' => '',
        'titleHide' => false,
        'titleDomElement' => 'h1',
        'titleColor' => '',
        'titleClass' => ''
    ],

    'widgets' => [
        'widgets/blogs.php'
    ],

    'events' => [
        'view.system/site/admin/edit' => function ($event, $view) use ($app) {
            $view->script('node-theme', 'theme:app/bundle/node-theme.js', 'site-edit');
        },

        'view.system/widget/edit' => function ($event, $view) {
            $view->script('widget-theme', 'theme:app/bundle/widget-theme.js', 'widget-edit');
        },

        'view.layout' => function( $event , $view) use ($app) {
            if($app->isAdmin()){
                return;
            }
            $params = $view->params;
            $userConfig = $app['config']->get('system/user');
            $params['registration_permit'] = $userConfig->get('registration') != 'admin' && $app['user']->isAnonymous() ? true:false;
        }
    ]
];
