<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Test\Google\OAuth2;

use alxmsl\Google\OAuth2\Response\Error;
use PHPUnit_Framework_TestCase;

/**
 * Error class test
 * @author alxmsl
 */
final class ErrorTest extends PHPUnit_Framework_TestCase {
    public function test() {
        $Error1 = Error::initializeByString('{
            "error": "invalid_request"
        }');
        $this->assertFalse($Error1->isInvalidClient());
        $this->assertFalse($Error1->isInvalidGrant());

        $Error2 = Error::initializeByString('{
            "error": "invalid_client"
        }');
        $this->assertTrue($Error2->isInvalidClient());
        $this->assertFalse($Error2->isInvalidGrant());

        $Error3 = Error::initializeByString('{
            "error": "invalid_grant"
        }');
        $this->assertFalse($Error3->isInvalidClient());
        $this->assertTrue($Error3->isInvalidGrant());
    }
}
