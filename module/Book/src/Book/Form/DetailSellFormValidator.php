<?php
namespace Book\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class DetailSellFormValidator implements InputFilterAwareInterface
{
    protected $inputFilter;
    protected $availableID;
    protected $availableStock;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function setAvailableID($availableID)
    {
        $this->availableID = $availableID;
    }

    public function setAvailableStock($availableStock)
    {
    	$this->availableStock = $availableStock;
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter)
        {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            $lessThanMessage = 'Book Stock Available = ' . $this->availableStock . '';
            
            $inputFilter->add($factory->createInput([
                'name' => 'book',
                'required' => 'true',
                'disableInArrayValidation' => 'true',
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => $this->availableID,
                            'messages' => array(
                                'notInArray' => 'The choosen item is not available / Out of Stock !'  
                            ),
                        ),
                    ),
                ),
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'qty',
                'required' => 'true',
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array('isEmpty' => 'Book Qty Required !')
                        ),
                    ),
                    array(
                        'name' => 'Digits',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array('notDigits' => 'Book Qty Must be a Number !')
                        ),
                    ),
                    array(
                        'name' => 'greaterThan',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'min' => 0,
                            'messages' => array('notGreaterThan' => 'Book Qty Must > %min%')
                        ),
                    ),
                    array(
                        'name' => 'lessThan',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'max' => $this->availableStock+1,
                            'messages' => array('notLessThan' => $lessThanMessage)
                        ),
                    ),
                ),
            ]));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}
?>