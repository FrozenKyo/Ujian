<?php
namespace Book\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

Class AuthController extends AbstractActionController
{
	public function indexAction()
	{
		return new ViewModel(array(
		    
		));
	}

	public function logoutAction()
	{
		return new ViewModel(array(
		    
		));
	}

	public function detailAction()
	{
		return new ViewModel(array(
		    
		));
	}
}

?>