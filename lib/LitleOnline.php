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
define('CURRENT_XML_VERSION', '8.24');
define('CURRENT_SDK_VERSION', 'PHP;8.24.0');
define('MAX_TXNS_PER_BATCH', 100000);
define('MAX_TXNS_PER_REQUEST', 500000);
define('LITLE_CONFIG_LIST', 'user,password,merchantId,timeout,proxy,reportGroup,version,url,litle_requests_path,batch_requests_path,sftp_username,sftp_password,batch_url,tcp_port,tcp_ssl,tcp_timeout,print_xml');
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
// Only Load if exists
if (file_exists(realpath(dirname(__FILE__) . '/../vendor/autoload.php')))
{
    require realpath(dirname(__FILE__)) . '/../vendor/autoload.php';
}
