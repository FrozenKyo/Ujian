<?php
namespace Buku\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form;

class TransaksiForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('Transaksi\Form'); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'tglTrans',
            'type' => 'Zend\Form\Element\Date', 
            'attributes' => array( 
                'placeholder' => 'dd-MM-yyyy', 
                'min' => '1970-01-01', 
                'max' => 2014-6-5, 
                'step' => '1', 
            ), 
            'options' => array( 
                'label' => 'Tanggal Penjualan', 
            ), 
        ));
 
 		$this->add(array( 
            'name' => 'customer', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Nama Customer', 
            ), 
            'options' => array( 
            	'label' => 'Nama Customer',
            ), 
        ));
 
 		$this->add(array( 
            'name' => 'buku', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
            	
            ), 
            'options' => array( 
                'label' => 'Pilih Buku', 
                'value_options' => array(
                    
                ),
            ),
        )); 
		
		$this->add(array( 
            'name' => 'qty',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Qty', 
            ), 
            'options' => array( 
            	'label' => 'Qty Penjualan',
            ), 
        ));
		
		$this->add(array(
            'name' => 'save',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Save'
            ),
        ));
		
		$this->add(array(
            'name' => 'add',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Add'
            ),
        ));
    }
}
?>