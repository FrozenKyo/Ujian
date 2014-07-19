<?php
namespace Book\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

Class ReportController extends AbstractActionController
{
	public function indexAction()
	{
		return new ViewModel(array(
		    
		));
	}

	public function pdfAction()
	{
		return new ViewModel(array(
		    
		));
	}

	public function excelAction()
	{
		return new ViewModel(array(
		    
		));
	}
}

?>