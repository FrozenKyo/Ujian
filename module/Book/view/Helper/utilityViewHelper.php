<?php
namespace Book\view\Helper;

use Zend\View\Helper\AbstractHelper;

class UtilityPlugin extends AbstractHelper
{
	public function __invoke()
    {
        $this->count++;
        $output = sprintf("I have seen 'The Jerk' %d time(s).", $this->count);
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
	
	public function toMoney($value)
	{
		return number_format($value , 0 , "." , ",");
	}

	public function thousandSeparator($value)
	{
		return number_format($value , 0 , "" , ",");
	}	
}

?>