<?php
namespace Book\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class DetailSellForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'book',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(),
            'options' => array(
                'label' => 'Select Book',
                'value_options' => array(
                    'CONAN' => 'CONAN EDOGAWA',
                    'SHINCAN' => 'CRAYON SINCHAN',
                    'NOBITA' => 'DORAEMON'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'qty',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Qty > 0',
            ),
            'options' => array(
                'label' => 'Sell Qty',
            ),
        ));
        $this->add(array(
            'name' => 'add',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Add Book'
            ),
        ));
    }
}
?>