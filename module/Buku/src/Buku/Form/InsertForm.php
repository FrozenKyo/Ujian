<?php
namespace Buku\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form;

class InsertForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('Insert\Form'); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'nama', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Nama Buku', 
            ), 
            'options' => array( 
                'label' => 'Nama Buku',
            ), 
        )); 
 
 		$this->add(array( 
            'name' => 'stok', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Stok', 
            ), 
            'options' => array( 
            	'label' => 'Stok Buku',
            ), 
        ));
 		
		$this->add(array( 
            'name' => 'harga', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Harga',
            ), 
            'options' => array(
            	'label' => 'Harga Buku',
            ), 
        ));
 
 		$this->add(array( 
            'name' => 'status', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
            ), 
            'options' => array( 
                'label' => 'Drop Down', 
                'value_options' => array(
                    '1' => 'Active', 
                    '0' => 'Inactive', 
                ),
            ),
        )); 
		
		$this->add(array(
            'name' => 'save',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Save'
            ),
        ));
		
    }
}
?>