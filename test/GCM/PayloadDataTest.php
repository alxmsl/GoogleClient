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

use alxmsl\Google\GCM\Message\CustomPayloadData;
use alxmsl\Google\GCM\Message\PayloadData;
use alxmsl\Google\GCM\Message\PayloadMessage;
use PHPUnit_Framework_TestCase;

/**
 * Payload data test class
 * @author alxmsl
 */
final class PayloadDataTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        /** @var PayloadData $Mock */
        $Mock = $this->getMockForAbstractClass(PayloadData::class);
        $this->assertEquals(PayloadMessage::TYPE_PLAIN, $Mock->getType());
    }

    public function testProperties() {
        /** @var PayloadData $Mock */
        $Mock = $this->getMockForAbstractClass(PayloadData::class);
        $Mock->setType(PayloadMessage::TYPE_PLAIN);
        $this->assertEquals(PayloadMessage::TYPE_PLAIN, $Mock->getType());
        $Mock->setType(PayloadMessage::TYPE_JSON);
        $this->assertEquals(PayloadMessage::TYPE_JSON, $Mock->getType());
    }

    public function testExportPlain() {
        $Payload1 = new CustomPayloadData([]);
        $this->assertEquals([], $Payload1->export());

        $Payload2 = new CustomPayloadData([
            'key1' => 'val1',
            'key2' => 'val2',
            'key3' => 'val3',
            7
        ]);
        $this->assertEquals([
            'data.key1' => 'val1',
            'data.key2' => 'val2',
            'data.key3' => 'val3',
            'data.0'    => 7,
        ], $Payload2->export());
    }

    public function testExportJson() {
        $Payload1 = new CustomPayloadData([]);
        $Payload1->setType(PayloadMessage::TYPE_JSON);
        $this->assertEquals([
            'data' => [],
        ], $Payload1->export());

        $Payload2 = new CustomPayloadData([
            'key1' => 'val1',
            'key2' => 'val2',
            'key3' => 'val3',
            7
        ]);
        $Payload2->setType(PayloadMessage::TYPE_JSON);
        $this->assertEquals([
            'data' => [
                'key1' => 'val1',
                'key2' => 'val2',
                'key3' => 'val3',
                0      => 7,
            ],
        ], $Payload2->export());
    }
}
