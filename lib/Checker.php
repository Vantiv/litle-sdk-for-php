<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Checker
{
	function requiredValue($value)
	{
		if ($value != null)
		{
			return $value;
		}
		else
		{
			return "REQUIRED";
			#change this later to raise a standard error
		}
	}
	
}
?>
