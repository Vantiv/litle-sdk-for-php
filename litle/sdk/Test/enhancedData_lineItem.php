<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../../vendor/autoload.php';
#Sale
$sale_info = array(
              'id' => 1,
              'orderId' => '1',
              'amount' => '10010',
              'orderSource'=>'ecommerce',
              'billToAddress'=>array(
              'name' => 'John Smith',
              'addressLine1' => '1 Main St.',
              'city' => 'Burlington',
              'state' => 'MA',
              'zip' => '01803-3747',
              'country' => 'US'),
              'card'=>array(
              'number' =>'5112010000000003',
              'expDate' => '0112',
              'cardValidationNum' => '349',
              'type' => 'MC'
              ),
              'enhancedData' => array(
                  'salesTax' => 200,
                  'taxExempt' => false,
                  'lineItemData' => array(
                      'itemSequenceNumber' => '1',
                      'itemDescription' => 'product 1',
                      'productCode' => '123',
                      'quantity' => 3,
                      'unitOfMeasure' => 'unit',
                      'taxAmount' => 200,
                      'detailTax' => array(
                          'taxIncludedInTotal' => true,
                          'taxAmount' => 200
                      )
                  )
              ),
            );
$initialize = &new LitleOnlineRequest();
$saleResponse = $initialize->saleRequest($sale_info);
#display results
echo ("Response: " . (XmlParser::getNode($saleResponse,'response'))) . "\n";
echo ("Message: " . XmlParser::getNode($saleResponse,'message')) . "\n";
