<?php
#error_reporting(E_ALL);
#ini_set('display_errors', '1');

class Checker
{
	function required_field($value)
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
	
	function optional_field($value)
	{
		if ($value != null)
		{
			return $value;
		}
		else
		{
			return "VALUE";
			#unset($value);
			#change this later to raise a standard error
		}
	}
}
?>
