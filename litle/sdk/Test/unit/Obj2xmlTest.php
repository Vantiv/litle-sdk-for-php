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
namespace litle\sdk\Test\unit;
use litle\sdk\Obj2xml;
class Obj2xmlTest extends \PHPUnit_Framework_TestCase
{
    public function test_enhanced_data_more_than_10_line_items()
    {
        $hash=
            array("merchantSdk"=>'',"enhancedData" =>
            array(
                "lineItemData1" =>  (array("itemSequenceNumber"=>"1","itemDescription"=>"First")),
                "lineItemData2" =>  (array("itemSequenceNumber"=>"2","itemDescription"=>"Second")),
                "lineItemData3" =>  (array("itemSequenceNumber"=>"3","itemDescription"=>"Third")),
                "lineItemData4" =>  (array("itemSequenceNumber"=>"4","itemDescription"=>"Fourth")),
                "lineItemData5" =>  (array("itemSequenceNumber"=>"5","itemDescription"=>"Fifth")),
                "lineItemData6" =>  (array("itemSequenceNumber"=>"6","itemDescription"=>"Sixth")),
                "lineItemData7" =>  (array("itemSequenceNumber"=>"7","itemDescription"=>"Seventh")),
                "lineItemData8" =>  (array("itemSequenceNumber"=>"8","itemDescription"=>"Eighth")),
                "lineItemData9" =>  (array("itemSequenceNumber"=>"9","itemDescription"=>"Ninth")),
                "lineItemData10" =>  (array("itemSequenceNumber"=>"10","itemDescription"=>"Tenth")),
                "lineItemData11" =>  (array("itemSequenceNumber"=>"11","itemDescription"=>"Eleventh"))
            ));
        $outputxml = Obj2xml::toXml($hash,array(),'authorization');
        //Finding this means the schema will fail validation
        $this->assertTrue(FALSE === strpos($outputxml,'lineItemData11'));
    }
}
