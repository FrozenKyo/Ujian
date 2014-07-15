<?php

namespace Buku\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class AuthPlugin extends AbstractPlugin {
	public function checkAuth() {
		$auth = $this->getController()->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
        if (!$auth->hasIdentity()) {
        	$this->getController()->redirect()->toRoute('auth', array('action'=>'index'));
        }
	}
}

?>