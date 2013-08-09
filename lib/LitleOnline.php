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
define('CURRENT_XML_VERSION', '8.19');
define('MAX_TXNS_PER_BATCH', 100000);
define('MAX_TXNS_PER_REQUEST', 500000);
require_once realpath(dirname(__FILE__)) . '/LitleXmlMapper.php';
require_once realpath(dirname(__FILE__)) . '/XmlFields.php';
require_once realpath(dirname(__FILE__)) . '/Communication.php';
require_once realpath(dirname(__FILE__)) . '/XmlParser.php';
require_once realpath(dirname(__FILE__)) . '/Obj2xml.php';
require_once realpath(dirname(__FILE__)) . '/Checker.php';
require_once realpath(dirname(__FILE__)) . '/LitleOnlineRequest.php';
require_once realpath(dirname(__FILE__)) . '/UrlMapper.php';
require_once realpath(dirname(__FILE__)) . '/BatchRequest.php';
require_once realpath(dirname(__FILE__)) . '/LitleRequest.php';
require_once realpath(dirname(__FILE__)) . '/Transactions.php';
require_once realpath(dirname(__FILE__)) . '/LitleResponseProcessor.php';
require_once realpath(dirname(__FILE__)) . '/resources/Net/SFTP.php';
$ssh_path = dirname(__FILE__) . '/resources/';
set_include_path(get_include_path() . PATH_SEPARATOR . $ssh_path);