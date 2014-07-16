<?php
return array(
	'controller_plugins' => array(
		'invokables' => array(
            'authPlugin' => 'Buku\Controller\Plugin\AuthPlugin',
            'myPlugin' => 'Buku\Controller\Plugin\MyPlugin',
		),
    ),
	// Controller
    'controllers' => array(
        'invokables' => array(
            'Buku\Controller\Buku' => 'Buku\Controller\BukuController',
            'Buku\Controller\Delete' => 'Buku\Controller\DeleteController',
            'Buku\Controller\Login' => 'Buku\Controller\LoginController',
            'Buku\Controller\Test' => 'Buku\Controller\TestController',
            'Buku\Controller\Transaksi' => 'Buku\Controller\TransaksiController',
            'Buku\Controller\ConvertPdf' => 'Buku\Controller\ConvertPdfController',
            'Buku\Controller\ConvertExcel' => 'Buku\Controller\ConvertExcelController',
            'Buku\Controller\ConvertChart' => 'Buku\Controller\ConvertChartController',
        ),
    ),
    
    // Router
    'router' => array(
        'routes' => array(
            'buku' => array( // Nama route
                'type' => 'segment',
                'options' => array(
                    'route' => '[/:lang]/buku/:action[/:page][/:id]',
                    'defaults' => array(
                        'controller' => 'Buku\Controller\Buku', // Controller yang bertugas
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
            'convertpdf' => array( // Nama route
                'type' => 'segment',
                'options' => array(
                    'route' => '/convertpdf',
                    'defaults' => array(
                        'controller' => 'Buku\Controller\ConvertPdf', // Controller yang bertugas
                        'action' => 'convert',
                    ),
                ),
            ),
            'convertexcel' => array( // Nama route
                'type' => 'segment',
                'options' => array(
                    'route' => '/convertexcel',
                    'defaults' => array(
                        'controller' => 'Buku\Controller\ConvertExcel', // Controller yang bertugas
                        'action' => 'convert',
                    ),
                ),
            ),
            'convertchart' => array( // Nama route
                'type' => 'segment',
                'options' => array(
                    'route' => '/convertchart',
                    'defaults' => array(
                        'controller' => 'Buku\Controller\ConvertChart', // Controller yang bertugas
                        'action' => 'convert',
                    ),
                ),
            ),
            'logout' => array( // Nama route
                'type' => 'segment',
                'options' => array(
                    'route' => '/auth/logout',
                    'defaults' => array(
                        'controller' => 'Buku\Controller\Login', // Controller yang bertugas
                        'action' => 'logout',
                    ),
                ),
            ),
            'test' => array( // Nama route
                'type' => 'segment',
                'options' => array(
                    'route' => '/test',
                    'defaults' => array(
                        'controller' => 'Buku\Controller\test', // Controller yang bertugas
                        'action' => 'test',
                    ),
                ),
            ),
            'transaksi' => array( // Nama route
                'type' => 'segment',
                'options' => array(
                    'route' => '[/:lang]/transaksi/:action[/:page]',
                    'defaults' => array(
                        'controller' => 'Buku\Controller\Transaksi', // Controller yang bertugas
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
            'auth' => array( // Nama route
                'type' => 'segment',
                'options' => array(
                    'route' => '/auth',
                    'defaults' => array(
                        'controller' => 'Buku\Controller\Login', // Controller yang bertugas
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    // View
    'view_manager' => array(
        'template_path_stack' => array(
            'myapplication' => __DIR__ . '/../view',
        ),
    ),
    
	//Doctrine ORM
    'doctrine' => array(
	    'driver' => array(
	        'buku_driver' => array( // ===> Driver name
	            'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
	            'cache' => 'array',
	            'paths' => array(__DIR__ . '/../src/Buku/XML')
	        ),
	        'orm_default' => array(
	            'drivers' => array(
	                'Buku\Model\Entity' => 'buku_driver' // ===> Registered driver name.
	            )
	        )
		),
		'authentication' => array(
            'orm_default' => array(
                //should be the key you use to get doctrine's entity manager out of zf2's service locator
                'objectManager' => 'Doctrine\ORM\EntityManager',
                //fully qualified name of your user class
                'identityClass' => 'Buku\Model\Entity\Kasir',
                //the identity property of your class
                'identityProperty' => 'username',
                //the password property of your class
                'credentialProperty' => 'password',
                //a callable function to hash the password with
                //'credentialCallable' => 'Buku\Model\Entity\Kasir::hashPassword'
            ),
        ),
	),
);
?>