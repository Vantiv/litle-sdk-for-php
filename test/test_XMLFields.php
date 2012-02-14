<?php
#require_once realpath(dirname(__FILE__)) . '/../simpletest/test/autorun.php';
require_once('../simpletest/autorun.php');
require_once realpath(dirname(__FILE__)) . '/../lib/XMLFields.php';

class AllTests extends UnitTestCase{
	
	function test_simple_contact()
	{
		$hash = array(
		'firstName' =>'Greg',
		'lastName'=>'Formich',
		'companyName'=>'Litleco',
		'addressLine1'=>'900 chelmosford st',
		'city'=> 'Lowell',
		'state'=>'MA',
		'zip'=>'01831',
		'country'=>'US');
        $hash_out = XMLFields::contact($hash);
		$this->assertEqual($hash_out['firstName'],'Greg');
		$this->assertEqual($hash_out['addressLine2'], NULL);
		$this->assertEqual($hash_out['city'],'Lowell');
	}
}
?>
