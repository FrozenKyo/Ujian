<?php
namespace Book\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class HeaderSellFormValidator implements InputFilterAwareInterface
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
            'name' => 'customer',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'string_length',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'max' => 50,
                        'message' => array('stringLengthTooLong' => 'Max Customer Name Length is 50 Character !')
                    )
                ),
            ),
        ]));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}
?>