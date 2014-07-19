<?php
namespace Book\Controller\PluginController;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class UtilityPlugin extends AbstractPlugin
{
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