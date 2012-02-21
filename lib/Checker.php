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
		}
	}

	function optional_field($hash)
	{
		if (count($hash) == 1 || count($hash) == 0)
		{
			return $hash;
		}
		else
		{
			$i= 0;
			foreach ($hash as  $key => $value){
				$i|=($value);
				//if ($value != NULL){
				//	$i=1;
				//}
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

	function choice($choiceArray)
	{
		$i= 0;
		for($y=0;$y<count($choiceArray);$y++){
			if (isset($choiceArray[$y])){
				$i++;
			}
		}
		if ( $i > 1)
		{
			throw new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
		}
	}

	function requiredMissing($hash){

		foreach ($hash as $key => $value)
		{
			if ($value == "REQUIRED"){
				throw new Exception("Missing Required Field: /$key/");
			}
		}

	}

	function exists($hash_in,$hash_out)
	{
		// 		$i = O;
		// 		foreach($hash_in as $key => $value)
		// 		{
		// 			echo $value;
		// 			#$i|=($value);
		// 		}
		if (is_array($hash_in))
		{
			return $hash_out;
		}
	}
}
?>
