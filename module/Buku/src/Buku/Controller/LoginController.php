<?php

namespace Buku\Controller;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as Collection;
use Zend\Paginator\Paginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Buku\Form as BF;

Class LoginController extends AbstractActionController
{
	public function indexAction()
	{
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
	        $auth->getAdapter()->setIdentityValue($request->getPost('txtUsername'));
	        $auth->getAdapter()->setCredentialValue($request->getPost('txtPassword'));
	        $result = $auth->authenticate();
			if($result->isValid()) {
				$this->flashMessenger()->addMessage("Login Berhasil");
				return $this->redirect()->toRoute('buku', array('action'=>'index'));
			}  else {
				$this->flashMessenger()->addMessage("Username/Password Salah");
				return $this->redirect()->toRoute('auth', array('action'=>'index'));
			}
		}
		
		$form = new BF\LoginForm;
		
		return new ViewModel(array(
		    'form' => $form,
		    'messages' => $this->flashMessenger(),
		));
	}
	
	public function logoutAction()
    {
    	$auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
        //$auth->getAdapter()->getSessionStorage()->forgetMe();
        $auth->clearIdentity();
         
        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('auth');
    }
	
	
}
?>