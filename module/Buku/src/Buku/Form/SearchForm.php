<?php
namespace Buku\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form; 

class SearchForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('Latihan\Form'); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'nama', 
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array( 
                'placeholder' => 'Masukkan Nama', 
            ), 
            'options' => array( 
                'label' => 'Nama Buku', 
            ), 
        )); 
 
		$this->add(array(
            'name' => 'search',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Search'
            ),
        ));
    }
}
?>