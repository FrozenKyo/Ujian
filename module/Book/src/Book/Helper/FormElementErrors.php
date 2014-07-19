<?php
namespace Book\Helper;

use Zend\Form\View\Helper\FormElementErrors as OriginalFormElementErrors;

class FormElementErrors extends OriginalFormElementErrors  
{
    /*protected $messageCloseString     = '</li></ul>';
    protected $messageOpenFormat      = '<ul%s><li class="no-bullet">';
    protected $messageSeparatorString = '</li><li">';*/

    protected $messageCloseString     = '</span>';
    protected $messageOpenFormat      = '<span%s class="red-text">';
    protected $messageSeparatorString = '</span><span>';
}
?>