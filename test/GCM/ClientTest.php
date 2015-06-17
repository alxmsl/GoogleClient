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

namespace alxmsl\Test\Google\GCM;

use alxmsl\Google\GCM\Client;
use alxmsl\Google\GCM\Exception\GCMFormatException;
use alxmsl\Google\GCM\Message\PayloadMessage;
use PHPUnit_Framework_TestCase;

/**
 * GCM Client class tests
 * @author alxmsl
 */
final class ClientTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Client = new Client();
        $this->assertEmpty($Client->getAuthorizationKey());
        $this->assertNotNull($Client->getRequest());
    }

    public function testProperties() {
        $Client = new Client();
        $Client->setAuthorizationKey('someKEY');
        $this->assertEquals('someKEY', $Client->getAuthorizationKey());
    }

    public function testSend() {
        $Message = new PayloadMessage();
        $Message->setType(56);

        $Client = new Client();
        try {
            $Client->send($Message);
            $this->fail();
        } catch (GCMFormatException $Ex) {}
    }
}
