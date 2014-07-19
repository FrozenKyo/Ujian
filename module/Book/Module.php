<?php
namespace Book;

class Module
{
	public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	
	// REGISTER VIEW HELPER via factories (For Pager In This Case)
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'Requesthelper' => function($sm){
                     $helper = new Helper\RequestHelper;
                     $request = $sm->getServiceLocator()->get('Request');
                     $helper->setRequest($request);
                     return $helper;
                 }
             ),
        );
    }
}
?>