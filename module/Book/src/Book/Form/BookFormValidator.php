<?php
namespace Book\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class BookFormValidator implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter)
        {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

        $inputFilter->add($factory->createInput([
            'name' => 'name',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array('isEmpty' => 'Book Name required !')
                    ),
                ),
                array(
                    'name' => 'string_length',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'max' => 50,
                        'messages' => array(
                                'stringLengthTooLong' => 'Max Book Name Length is 50 Character !',
                                'stringLengthTooShort' => 'Min Book Name Length is 1 Character !'
                            )
                    ),
                ),
            ),
        ]));
        $inputFilter->add($factory->createInput([
            'name' => 'stock',
            'required' => 'true',
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array('isEmpty' => 'Book Stock required !')
                    ),
                ),
                array(
                    'name' => 'Digits',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array('notDigits' => 'Book Stock must be a number !')
                    ),
                ),
            ),
        ]));
        $inputFilter->add($factory->createInput([
            'name' => 'price',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array('isEmpty' => 'Book Price required !')
                    ),
                ),
                array(
                    'name' => 'greaterThan',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'min' => 0,
                        'messages' => array('notGreaterThan' => 'Book Price Must be Greater Than %min%')
                    ),
                ),
                array(
                    'name' => 'Digits',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array('notDigits' => 'Book Price must be a number !')
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