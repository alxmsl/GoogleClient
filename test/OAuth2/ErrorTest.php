<?php
/*
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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
