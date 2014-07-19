<?php
namespace Book\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DetailSellForm extends Form implements ObjectManagerAwareInterface
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager,$name = null)
    {
        $this->setObjectManager($objectManager);
 
        parent::__construct('');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-inline');

        //Service
        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'book',
            'options' => array(
                'label'          => 'Choose Book',
                'object_manager' => $this->getObjectManager(),
                'target_class'   => 'Book\Model\Entity\Book',
                'property'       => 'name',
                'empty_option'   => '--- select a book ---',
                'is_method'      => true,
                'find_method'    => array(
                    'name'   => 'findBy',
                    'params' => array(
                        'criteria' => array('status' => true),
                        'orderBy'  => array('name' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control'
            ),
        ));
        $this->add(array(
            'name' => 'qty',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
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
                'value' => 'Add Book',
                'class' => 'btn btn-default'
            ),
        ));
        $this->add(array(
            'name' => 'save',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Save Transaction',
                'class' => 'btn btn-default'
            ),
        ));
    }

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
 
        return $this;
    }
 
    public function getObjectManager()
    {
        return $this->objectManager;
    }
}
?>