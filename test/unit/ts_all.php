<?php
/*
* Copyright (c) 2011 Litle & Co.
*
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/

require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';

require realpath(dirname(__FILE__)) . '/test_XmlFields.php';
require realpath(dirname(__FILE__)) . '/test_sale.php';
require realpath(dirname(__FILE__)) . '/test_authorization.php';
require realpath(dirname(__FILE__)) . '/test_authReversal.php';
require realpath(dirname(__FILE__)) . '/test_credit.php';
require realpath(dirname(__FILE__)) . '/test_token.php';
require realpath(dirname(__FILE__)) . '/test_forceCapture.php';
require realpath(dirname(__FILE__)) . '/test_capture.php';
require realpath(dirname(__FILE__)) . '/test_captureGivenAuth.php';
require realpath(dirname(__FILE__)) . '/test_echeckRedeposit.php';
require realpath(dirname(__FILE__)) . '/test_echeckSale.php';
require realpath(dirname(__FILE__)) . '/test_echeckCredit.php';
require realpath(dirname(__FILE__)) . '/test_echeckVerification.php';
require realpath(dirname(__FILE__)) . '/test_litleOnlineRequest.php';
require realpath(dirname(__FILE__)) . '/test_void.php';
require realpath(dirname(__FILE__)) . '/test_Checker.php';
require realpath(dirname(__FILE__)) . '/test_XmlParser.php';
require realpath(dirname(__FILE__)) . '/test_Obj2xml.php';
require realpath(dirname(__FILE__)) . '/test_updateCardValidationNumOnToken.php';
require realpath(dirname(__FILE__)) . '/test_transactions.php';
require realpath(dirname(__FILE__)) . '/test_updateSubscription.php';
require realpath(dirname(__FILE__)) . '/test_cancelSubscription.php';
require realpath(dirname(__FILE__)) . '/test_createPlan.php';
require realpath(dirname(__FILE__)) . '/test_updatePlan.php';
require realpath(dirname(__FILE__)) . '/test_activate.php';
require realpath(dirname(__FILE__)) . '/test_deactivate.php';
require realpath(dirname(__FILE__)) . '/test_load.php';
require realpath(dirname(__FILE__)) . '/test_unload.php';
require realpath(dirname(__FILE__)) . '/test_balanceInquiry.php';
class UnitTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('PHPUnit');
		$suite->addTestSuite('auth_UnitTest');
		$suite->addTestSuite('authReversal_UnitTest');
		$suite->addTestSuite('capture_UnitTest');
		$suite->addTestSuite('captureGivenAuth_UnitTest');
		$suite->addTestSuite('checker_UnitTest');
		$suite->addTestSuite('credit_UnitTest');
		$suite->addTestSuite('echeckCredit_UnitTest');
		$suite->addTestSuite('echeckRedeposit_UnitTest');
		$suite->addTestSuite('echeckSale_UnitTest');
		$suite->addTestSuite('echeckVerification_UnitTest');
		$suite->addTestSuite('forceCapture_UnitTest');
		$suite->addTestSuite('LitleOnlineRequest_UnitTest');
		$suite->addTestSuite('sale_UnitTest');
		$suite->addTestSuite('token_UnitTest');
		$suite->addTestSuite('void_UnitTest');
		$suite->addTestSuite('Tests_XmlFields');
		$suite->addTestSuite('Tests_XmlParser');
		$suite->addTestSuite('Tests_Obj2xml');
		$suite->addTestSuite('updateCardValidationNumOnToken_UnitTest');
		$suite->addTestSuite('transactions_UnitTest');
		$suite->addTestSuite('updateSubscription_UnitTest');
		$suite->addTestSuite('cancelSubscription_UnitTest');
		$suite->addTestSuite('createPlan_UnitTest');
		$suite->addTestSuite('updatePlan_UnitTest');
        $suite->addTestSuite('activate_UnitTest');
        $suite->addTestSuite('deactivate_UnitTest');
        $suite->addTestSuite('load_UnitTest');
        $suite->addTestSuite('unload_UnitTest');
        $suite->addTestSuite('balanceInquiry_UnitTest');
		
		return $suite;
	}
}
