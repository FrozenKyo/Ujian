<?php
namespace Buku\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form;

class LoginForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('Login\Form'); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'txtUsername', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Username', 
            ), 
            'options' => array( 
                'label' => 'Username', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'txtPassword', 
            'type' => 'Zend\Form\Element\Password', 
            'attributes' => array( 
                'placeholder' => 'Password', 
            ), 
            'options' => array( 
                'label' => 'Password', 
            ), 
        )); 
 
		$this->add(array(
            'name' => 'btnLogin',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Login'
            ),
        ));
		
    }
}
?>