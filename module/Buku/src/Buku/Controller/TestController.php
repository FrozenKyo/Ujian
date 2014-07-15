<?php

namespace Buku\Controller;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as Collection;
use Zend\Paginator\Paginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Buku\Form as BF;

Class TestController extends AbstractActionController
{
	public function indexAction()
	{
		$this->AuthPlugin()->checkAuth();
		return new ViewModel(array(
		    
		));
	}
	
	public function testAction()
	{
		$session = new Container('ujian');
		$time = $session->kunjungan;
		if (!isset($session->kunjungan)) {
			$session->kunjungan = 10;
		} else {
			$session->kunjungan++;
		}
		//$session->offsetUnset('kunjungan');
		return new ViewModel(array(
		    'kunjungan' => $time,
		));
	}
}
?>