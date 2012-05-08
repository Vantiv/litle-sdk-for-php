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
require realpath(dirname(__FILE__)) .  '/test_sale.php';
require realpath(dirname(__FILE__)) .  '/test_auth.php';
require realpath(dirname(__FILE__)) .  '/test_authReversal.php';
require realpath(dirname(__FILE__)) .  '/test_credit.php';
require realpath(dirname(__FILE__)) .  '/test_token.php';
require realpath(dirname(__FILE__)) .  '/test_forceCapture.php';
require realpath(dirname(__FILE__)) .  '/test_capture.php';
require realpath(dirname(__FILE__)) .  '/test_captureGivenAuth.php';
require realpath(dirname(__FILE__)) .  '/test_void.php';
require realpath(dirname(__FILE__)) .  '/test_echeckRedeposit.php';
require realpath(dirname(__FILE__)) .  '/test_echeckSale.php';
require realpath(dirname(__FILE__)) .  '/test_echeckCredit.php';
require realpath(dirname(__FILE__)) .  '/test_echeckVerification.php';
require realpath(dirname(__FILE__)) .  '/test_echeckVoid.php';

class FunctionalTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('PHPUnit');
		$suite->addTestSuite('auth_FunctionalTest');
		$suite->addTestSuite('authReversal_FunctionalTest');
		$suite->addTestSuite('capture_FunctionalTest');
		$suite->addTestSuite('captureGivenAuth_FunctionalTest');
		$suite->addTestSuite('credit_FunctionalTest');
		$suite->addTestSuite('echeckCredit_FunctionalTest');
		$suite->addTestSuite('echeckRedeopist_FunctionalTest');
		$suite->addTestSuite('echeckSale_FunctionalTest');
		$suite->addTestSuite('echeckVerification_FunctionalTest');
		$suite->addTestSuite('echeckVoid_FunctionalTest');
		$suite->addTestSuite('forceCapture_FunctionalTest');
		$suite->addTestSuite('sale_FunctionalTest');
		$suite->addTestSuite('token_FunctionalTest');
		$suite->addTestSuite('void_FunctionalTest');
		$suite->addTestSuite('XmlFields_FunctionalTest');
		return $suite;
	}
}
