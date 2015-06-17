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

namespace alxmsl\Test\Google\AndroidPublisher\Purchases;

use alxmsl\Google\AndroidPublisher\Purchases\Client;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use UnexpectedValueException;

/**
 * AndroidPublisher client test class
 * @author alxmsl
 */
final class ClientTest extends PHPUnit_Framework_TestCase {
    public function test() {
        $Client1 = new Client();
        $this->assertEmpty($Client1->getPackage());

        $Client1->setPackage('com.example.example');
        $this->assertEquals('com.example.example', $Client1->getPackage());

        try {
            $Client1->get('', '');
            $this->fail();
        } catch (UnexpectedValueException $Ex) {}

        $Client2 = new Client(-1);
        $Client2->setPackage('com.example.example')
            ->setAccessToken('ACCEss_token');
        try {
            $Client2->get('', '');
            $this->fail();
        } catch (RuntimeException $Ex) {}
    }
}
