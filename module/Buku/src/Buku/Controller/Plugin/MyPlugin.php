<?php

namespace Buku\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class MyPlugin extends AbstractPlugin {
	
	public function toMoney($value) {
		return number_format($value , 0 , "." , ",");
	}
	
	/*
	public function logout() {
			
		}*/
	
}

?>