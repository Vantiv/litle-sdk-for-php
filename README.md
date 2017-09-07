Vantiv eCommerce PHP SDK
=====================
#### WARNING:
##### All major version changes require recertification to the new version. Once certified for the use of a new version, Vantiv modifies your Merchant Profile, allowing you to submit transaction to the Production Environment using the new version. Updating your code without recertification and modification of your Merchant Profile will result in transaction declines. Please consult you Implementation Analyst for additional information about this process.
About Vantiv eCommerce
------------
[Vantiv eCommerce](https://developer.vantiv.com/community/ecommerce) powers the payment processing engines for leading companies that sell directly to consumers through  internet retail, direct response marketing (TV, radio and telephone), and online services. Vantiv eCommerce is the leading authority in card-not-present (CNP) commerce, transaction processing and merchant services.


About this SDK
--------------
The Vantiv eCommerce PHP SDK is a PHP implementation of the [Vantiv eCommerce](https://developer.vantiv.com/community/ecommerce). XML API. This SDK was created to make it as easy as possible to connect process your payments with Vantiv eCommerce.  This SDK utilizes  the HTTPS protocol to securely connect to Vantiv eCommerce.  Using the SDK requires coordination with the Vantiv eCommerce team in order to be provided with credentials for accessing our systems.

Each PHP SDK release supports all of the functionality present in the associated Vantiv eCommerce XML version (e.g., SDK v9.3.2 supports Vantiv eCommerce XML v9.3). Please see the online copy of our XSD for Vantiv eCommerce XML to get more details on what the Vantiv eCommerce payments engine supports.

This SDK was implemented to support the PHP programming language and was created by Vantiv eCommerce. Its intended use is for online transaction processing utilizing your account on the Vantiv eCommerce payments engine.

See LICENSE file for details on using this software.

Source Code available from : https://github.com/LitleCo/litle-sdk-for-php

Please contact [Vantiv eCommerce](https://developer.vantiv.com/community/ecommerce) to receive valid merchant credentials in order to run tests successfully or if you require assistance in any way.  We are reachable at sdksupport@Vantiv.com

SDK PHP Dependencies
--------------
Up to date list available at [Packagist](https://packagist.org/packages/litle/payments-sdk)

Setup
============
Using with composer
--------------------
If you are using a composer to manage your dependencies, you can do the following in your project directory:

1) Install the composer using command:
> curl -sS https://getcomposer.org/install | php

2) Install dependencies using the command:
> php composer.phar install

3) Configure the SDK:
> cd litle/sdk
> php Setup.php

4) Run the attached sample:
```
<?php
require_once _DIR_.'/vendor/autoload.php';
#sale
$sale_info = array(
             'orderId' => '1',
             'amount'  => '10010',
             'orderSource' => 'ecommerce',
             'billToAddress' => array(
             'name' => 'John Smith' ,
             'addressLine1' => ' 1 Main St.',
             'city' => 'Burlington' ,
             'state' => 'MA' ,
             'zip' => '0183-3747',
             'country' => 'US'),
             'card' => array(
             'number' => '5112010000000003',
             'expDate' => '0112',
             'cardValidationNum' => '349',
             'type' => 'MC' )
            );
$initialize = new litle\sdk\LitleOnlineRequest();
$saleResponse =$initialize->saleRequest($sale_info);
#display results
echo ("Response: " . (litle\sdk\XmlParser::getNode($saleResponse,'response')) . "<br>");
echo ("Message: " . litle\sdk\XmlParser::getNode($saleResponse,'message') . "<br>");
echo ("Vantiv eCommerce Transaction ID: " . litle\sdk\XmlParser::getNode($saleResponse,'litleTxnId'));
```
> php your_sample_name

Using without composer
-----------------------
If you're not, you have to add a require for each and every class that's going to be used.

1) Configure the SDK
> cd into litle/sdk
> php Setup.php

2) Add the litle folder and require the path for your file

3) run your file 

> php your_file

Clone Repo
---------------

1) Install the LitleOnline PHP SDK from git. 

> git clone git://github.com/LitleCo/litle-sdk-for-php.git

> php ~/composer.phar install


2) Once the SDK is downloaded run our setup program to generate a configuration file.

> cd litle-sdk-for-php/lib

> php Setup.php

Running the above commands will create a configuration file in the lib directory. 


3) Create a symlink to the SDK

>ln -s /path/to/sdk /var/www/html/nameOfLink


4.) Create a php file similar to: 

```php
<?php
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
//Perform the transaction on the Vantiv eCommerce Platform
$initialize = new LitleOnlineRequest();
$saleResponse = $initialize->saleRequest($hash_in);

// Display Result 
echo ("Message: " . XMLParser::getNode($saleResponse,'message') . "<br>");
echo ("Vantiv eCommerce Transaction ID: " . XMLParser::getNode($saleResponse,'litleTxnId'));
```

As of 8.13.1, you may also use a tree-oriented style to get the response values:
```php
<?php
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
//Perform the transaction on the Vantiv eCommerce Platform
$initialize = new LitleOnlineRequest($treeResponse=true);
$saleResponse = $initialize->saleRequest($hash_in);

// Display Result 
echo ("Message: " . $saleResponse->saleResponse->message . "<br>");
echo ("Vantiv eCommerce Transaction ID: " . $saleResponse->saleResponse->litleTxnId);
```


NOTE: you may have to change the path to match that of your filesystems.  

If you get an error like:
```bash
PHP Fatal error:  require_once(): Failed opening required '/home/gdake/git/litle-sdk-for-php/../lib/LitleONline.php' (include_path='.:/usr/share/pear:/usr/share/php') in /home/gdake/git/litle-sdk-for-php/foo.php on line 2
```
You need to change the second line of your script to load the real location of LitleOnline.php

If you get an error like:
```bash
PHP Fatal error:  require(): Failed opening required '/home/gdake/litle-sdk-for-php/lib/../vendor/autoload.php' (include_path='.:/usr/share/php:/usr/share/pear') in /home/gdake/litle-sdk-for-php/lib/LitleOnline.php on line 42
```
You probably had a problem with composer.  You can safely remove line 42 if you are not using batch processing, or you can edit it to point at our dependencies that you've downloaded in another way.

5) Next run this file using php on the command line or inside a browser. You should see the following result provided you have connectivity to the Litle certification environment.  You will see an HTTP error if you don't have access to the Litle URL

    Message: Valid Format
    Vantiv eCommerce Transaction ID: <your-numeric-txn-id>

More examples can be found here [php Gists])(https://gist.github.com/litleSDK)

Please contact Litle & Co. with any further questions.   You can reach us at SDKSupport@Vantiv.com
