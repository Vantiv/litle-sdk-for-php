<?php
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
