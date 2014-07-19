<?php
namespace Book\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class HeaderTransactionSellForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'customer',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Customer Name',
            ),
            'options' => array(
                'label' => 'Customer Name',
            ),
        ));
        $this->add(array(
            'name' => 'save',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Save Transaction'
            ),
        ));
    }
}
?>