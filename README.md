Litle Online PHP SDK
=====================

About Litle
------------
[Litle &amp; Co.](http://www.litle.com) powers the payment processing engines for leading companies that sell directly to consumers through  internet retail, direct response marketing (TV, radio and telephone), and online services. Litle & Co. is the leading, independent authority in card-not-present (CNP) commerce, transaction processing and merchant services.


About this SDK
--------------
The Litle PHP SDK is a PHP implementation of the [Litle &amp; Co.](http://www.litle.com). XML API. This SDK was created to make it as easy as possible to connect process your payments with Litle.  This SDK utilizes  the HTTPS protocol to securely connect to Litle.  Using the SDK requires coordination with the Litle team in order to be provided with credentials for accessing our systems.

Our PHP supports all of the functionality present in Litle XML v8. Please see the online copy of our XSD for Litle XML to get more details on what is supported by the Litle payments engine.

This SDK is implemented to support the PHP programming language and was created by Litle & Co. It is intended use is for online transactions processing utilizing your account on the Litle payments engine.

See LICENSE file for details on using this software.

Source Code available from : https://github.com/LitleCo/litle-sdk-for-php

Please contact [Litle &amp; Co.](http://www.litle.com) to receive valid merchant credentials in order to run tests successfully or if you require assistance in any way.  We are reachable at sdksupport@litle.com

SDK PHP Dependencies
--------------
-pdo

-xml

-mysql

-gd

Setup
-----

1) Install the LitleOnline PHP SDK from git. 

>git clone git://github.com/LitleCo/litle-sdk-for-php.git


2) Once the SDK is downloaded run our setup program to generate a configuration file.

> cd litle-sdk-for-php/lib

> php Setup.php

Running the above commands will create a configuration file in the lib directory. 


3) Create a symlink to the SDK

>ln -s /path/to/sdk /var/www/html/nameOfLink


4.) Create a php file similar to: 

```php
require_once realpath(dirname(__FILE__)) . '/../lib/LitleOnline.php';  
    // Visa $10.00 sale
    $hash_in = array(
	      'amount'=>'106',
	      'orderId' => '123213',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	     'expDate' =>'1000')
	      );
//Perform the transaction on the Litle Platform
$initialize = new LitleOnlineRequest();
$saleResponse = $initialize->saleRequest($hash_in);

// Display Result 
echo ("Message: " . XMLParser::get_node($saleResponse,'message') . "<br>");
echo ("Litle Transaction ID: " . XMLParser::get_node($saleResponse,'litleTxnId'));
```

As of 8.13.1, you may also use a tree-oriented style to get the response values:
```php
require_once realpath(dirname(__FILE__)) . '/../lib/LitleOnline.php';  
    // Visa $10.00 sale
    $hash_in = array(
	      'amount'=>'106',
	      'orderId' => '123213',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	     'expDate' =>'1000')
	      );
//Perform the transaction on the Litle Platform
$initialize = new LitleOnlineRequest($treeResponse=true);
$saleResponse = $initialize->saleRequest($hash_in);

// Display Result 
echo ("Message: " . $saleResponse->saleResponse->message . "<br>");
echo ("Litle Transaction ID: " . $saleResponse->saleResponse->litleTxnId);
```


NOTE: you may have to change the path to match that of your filesystems

5) Next run this file using php on the command line or inside a browser. You should see the following result provided you have connectivity to the Litle certification environment.  You will see an HTTP error if you don't have access to the Litle URL

    Message: Valid Format
    Litle Transaction ID: <your-numeric-litle-txn-id>


Please contact Litle & Co. with any further questions.   You can reach us at SDKSupport@litle.com
