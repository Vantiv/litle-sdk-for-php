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
class UrlMapper
{
    const CERT = "cert";
    const PERCERT = "precert";
    const SANDBOX = "sandbox";
    const PRODUCTION1 = "production1";
    const PRODUCTION2 = "production2";

    public static function getUrl($litleEnv)
    {
		$litleOnlineCtx = 'vap/communicator/online';
		if ($litleEnv == UrlMapper::SANDBOX)
			return 'https://www.testlitle.com/sandbox/communicator/online';
		elseif ($litleEnv == UrlMapper::CERT)
			return 'https://cert.litle.com/' . $litleOnlineCtx;
		elseif ($litleEnv == UrlMapper::PRECERT)
			return 'https://precert.litle.com/' . $litleOnlineCtx;
		elseif ($litleEnv == UrlMapper::PRODUCTION1)
			return 'https://payments.litle.com/' . $litleOnlineCtx;
		elseif ($litleEnv == UrlMapper::PRODUCTION2)
			return 'https://payments2.litle.com/' . $litleOnlineCtx;
		else
			return 'https://www.testlitle.com/sandbox/communicator/online';
	}
}
