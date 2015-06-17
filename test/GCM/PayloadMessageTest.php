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
use alxmsl\Google\GCM\Message\PayloadMessage;
use PHPUnit_Framework_TestCase;

/**
 * Payload message test class
 * @author alxmsl
 */
final class PayloadMessageTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Message = new PayloadMessage();
        $this->assertEquals(PayloadMessage::TYPE_PLAIN, $Message->getType());
        $this->assertFalse($Message->needDelayWhileIdle());
        $this->assertFalse($Message->isDryRun());
        $this->assertEmpty($Message->getRestrictedPackageName());
        $this->assertFalse($Message->hasRestrictedPackageName());
        $this->assertNull($Message->getRegistrationIds());
        $this->assertEquals(0, $Message->getTimeToLive());
        $this->assertNull($Message->getData());
        $this->assertEquals([
            'delay_while_idle' => false,
            'dry_run'          => false,
        ], $Message->export());
    }

    public function testProperties() {
        $Message = new PayloadMessage();
        $Message->setType(PayloadMessage::TYPE_PLAIN);
        $this->assertEquals(PayloadMessage::TYPE_PLAIN, $Message->getType());
        $Message->setType(PayloadMessage::TYPE_JSON);
        $this->assertEquals(PayloadMessage::TYPE_JSON, $Message->getType());
        $Message->setDelayWhileIdle(true);
        $this->assertTrue($Message->needDelayWhileIdle());
        $Message->setDelayWhileIdle(false);
        $this->assertFalse($Message->needDelayWhileIdle());
        $Message->setDryRun(true);
        $this->assertTrue($Message->isDryRun());
        $Message->setDryRun(false);
        $this->assertFalse($Message->isDryRun());
        $Message->setRestrictedPackageName('PACKageNAME');
        $this->assertEquals('PACKageNAME', $Message->getRestrictedPackageName());
        $this->assertTrue($Message->hasRestrictedPackageName());

        $Message->setType(PayloadMessage::TYPE_PLAIN);
        $Message->setRegistrationIds('REGistrationID');
        $this->assertEquals('REGistrationID', $Message->getRegistrationIds());
        $Message->setType(PayloadMessage::TYPE_JSON);
        $Message->setRegistrationIds(['REGistrationID1', 'REGistrationID2']);
        $this->assertEquals(['REGistrationID1', 'REGistrationID2'], $Message->getRegistrationIds());
        $Message->setTimeToLive(30.50);
        $this->assertEquals(30, $Message->getTimeToLive());

        $this->assertEquals([
            'registration_ids'        => [
                'REGistrationID1',
                'REGistrationID2',
            ],
            'delay_while_idle'        => false,
            'dry_run'                 => false,
            'time_to_live'            => 30,
            'restricted_package_name' => 'PACKageNAME',
        ], $Message->export());
    }

    public function testDataProperty() {
        $Data    = new CustomPayloadData([
            'key1' => 'val1',
            'key2' => 54,
        ]);

        $Message1 = new PayloadMessage();
        $Message1->setType(PayloadMessage::TYPE_PLAIN);
        $Message1->setData($Data);
        $this->assertEquals([
            'data.key1'        => 'val1',
            'data.key2'        => 54,
            'delay_while_idle' => false,
            'dry_run'          => false,
        ], $Message1->export());

        $Message2 = new PayloadMessage();
        $Message2->setType(PayloadMessage::TYPE_JSON);
        $Message2->setData($Data);
        $this->assertEquals([
            'delay_while_idle' => false,
            'dry_run'          => false,
            'data'             => [
                'key1' => 'val1',
                'key2' => 54,
            ],
        ], $Message2->export());
    }
}
