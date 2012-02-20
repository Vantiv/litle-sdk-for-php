<?php
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

	function optional_field($hash)
	{
		$i= 0;
		foreach ($hash as  $key => $value){
			$i|=$value;
		}
	     if ($i == 0)
	     {
	     	unset($hash);
	     }
	     else
	     {
	     	return $hash;
	     }
	
	}
}
?>
