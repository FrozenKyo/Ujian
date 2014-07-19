<?php
return array(
    'view_helpers' => array(
        'invokables' => array(
            'formelementerrors' => 'Book\Helper\FormElementErrors'
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'utilityPlugin' => 'Book\Controller\PluginController\UtilityPlugin',
            'posDatabasePlugin' => 'Book\Controller\PluginController\PosDatabasePlugin',
        ),
    ),
	// Controller
    'controllers' => array(
        'invokables' => array(
            'Book\Controller\Book' => 'Book\Controller\BookController',
            'Book\Controller\SellTransaction' => 'Book\Controller\SellTransactionController'
        ),
    ),
    'router' => array( // Router
        'routes' => array(
            'book' => array( // Route Name
                'type' => 'segment',
                'options' => array(
                    'route' => '[/book][/:lang][/page][/:page]', // Matched route path
                    'constraint' => array(
                        'lang' => '[a-zA-Z]{2}',
                        'page' => '[0-9]+'
                    ),
                    'defaults' => array( // If no route define
                        'controller' => 'Book\Controller\Book',
                        'action' => 'index',
                    ),
                ),
            ),
            'new_entry' => array( // Route Name
                'type' => 'segment',
                'options' => array(
                    'route' => '[/book][/:lang]/new_entry', // Matched route path
                    'constraint' => array(
                        'lang' => '[a-zA-Z]{2}',
                    ),
                    'defaults' => array( // If no route define
                        'controller' => 'Book\Controller\Book',
                        'action' => 'new',
                    ),
                ),
            ),
            'prepare_edit_entry' => array( // Route Name
                'type' => 'segment',
                'options' => array(
                    'route' => '[/book][/:lang]/edit_entry/:id', // Matched route path
                    'constraint' => array(
                        'lang' => '[a-zA-Z]{2}',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array( // If no route define
                        'controller' => 'Book\Controller\Book',
                        'action' => 'prepareEdit',
                    ),
                ),
            ),
            'edit_entry' => array( // Route Name
                'type' => 'segment',
                'options' => array(
                    'route' => '[/book][/:lang]/edit_entry', // Matched route path
                    'constraint' => array(
                        'lang' => '[a-zA-Z]{2}',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array( // If no route define
                        'controller' => 'Book\Controller\Book',
                        'action' => 'edit',
                    ),
                ),
            ),
            'sell_transaction' => array( // Route Name
                'type' => 'segment',
                'options' => array(
                    'route' => '/sell_transaction[/:lang][/page][/:page]', // Matched route path
                    'constraint' => array(
                        'lang' => '[a-zA-Z]{2}',
                    ),
                    'defaults' => array( // If no route define
                        'controller' => 'Book\Controller\SellTransaction',
                        'action' => 'index',
                    ),
                ),
            ),
            'header_sell' => array( // Route Name
                'type' => 'segment',
                'options' => array(
                    'route' => '/sell_transaction[/:lang]/header_sell', // Matched route path
                    'constraint' => array(
                        'lang' => '[a-zA-Z]{2}',
                    ),
                    'defaults' => array( // If no route define
                        'controller' => 'Book\Controller\SellTransaction',
                        'action' => 'headerSell',
                    ),
                ),
            ),
            'detail_sell' => array( // Route Name
                'type' => 'segment',
                'options' => array(
                    'route' => '/sell_transaction[/:lang]/detail_sell/customer/[:customer]', // Matched route path
                    'constraint' => array(
                        'lang' => '[a-zA-Z]{2}',
                        'customer' => '[a-zA-Z]*'
                    ),
                    'defaults' => array( // If no route define
                        'controller' => 'Book\Controller\SellTransaction',
                        'action' => 'detailSell',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array( // View Manager
        'template_path_stack' => array(
            'myapplication' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'book_driver' => array( // ===> Driver name
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Book/XML')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Book\Model\Entity' => 'book_driver' // ===> Registered driver name.
                )
            )
        ),
    ),
);
?>