<?php
namespace Book\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class BookForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Book Name',
            ),
            'options' => array(
                'label' => 'Book Name',
            ),
        ));
        $this->add(array(
            'name' => 'stock',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Book Stock > 0',
            ),
            'options' => array(
            	'label' => 'Book Stock',
            ),
        ));
        $this->add(array(
            'name' => 'price',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Book Price > 0',
            ),
            'options' => array(
            	'label' => 'Book Price',
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