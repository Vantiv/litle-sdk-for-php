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
namespace litle\sdk;
class UrlMapper
{
    const POSTLIVE = "postlive";
    const SANDBOX = "sandbox";
    const PRODUCTION = "production";
    const TRANSACT_PRODUCTION = "transact_production";
    const TRANSACT_PRELIVE = "transact_prelive";
    const TRANSACT_POSTLIVE = "transact_postlive";
    const PRELIVE = "prelive";

    public static function getUrl($litleEnv)
    {
        $litleOnlineCtx = 'vap/communicator/online';
        if ($litleEnv == UrlMapper::SANDBOX)
            return 'https://www.testvantivcnp.com/sandbox/communicator/online';
        elseif ($litleEnv == UrlMapper::POSTLIVE)
            return 'https://payments.vantivpostlive.com/' . $litleOnlineCtx;
        elseif ($litleEnv == UrlMapper::PRODUCTION)
            return 'https://payments.vantivcnp.com/' . $litleOnlineCtx;
        elseif ($litleEnv == UrlMapper::TRANSACT_PRODUCTION)
            return 'https://transact.vantivcnp.com/' . $litleOnlineCtx;
        elseif ($litleEnv == UrlMapper::TRANSACT_PRELIVE)
            return 'https://transact.vantivprelive.com/' . $litleOnlineCtx;
        elseif ($litleEnv == UrlMapper::TRANSACT_POSTLIVE)
            return 'https://transact.vantivpostlive.com/' . $litleOnlineCtx;
        elseif ($litleEnv == UrlMapper::PRELIVE)
            return 'https://payments.vantivprelive.com/' . $litleOnlineCtx;
        else
            return 'https://www.testvantivcnp.com/sandbox/communicator/online';
    }
}
