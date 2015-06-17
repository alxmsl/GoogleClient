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

use alxmsl\Google\GCM\Message\PayloadMessage;
use alxmsl\Google\GCM\Response\Response;
use alxmsl\Google\GCM\Response\Status;
use PHPUnit_Framework_TestCase;

/**
 * Status class tests
 * @author alxmsl
 */
final class StatusTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Status = new Status();
        $this->assertEmpty($Status->getCanonicalId());
        $this->assertEmpty($Status->getError());
        $this->assertEmpty($Status->getMessageId());
        $this->assertFalse($Status->hasCanonicalId());
        $this->assertFalse($Status->mustRemove());
        $this->assertFalse($Status->canRetry());
    }

    public function testPlainInitialization() {
        Response::$type = PayloadMessage::TYPE_PLAIN;

        $Response1 = Response::initializeByString('id=1:08');
        $this->assertInstanceOf(Status::class, $Response1->getResults()[0]);
        $Status1 = $Response1->getResults()[0];
        $this->assertEmpty($Status1->getCanonicalId());
        $this->assertEmpty($Status1->getError());
        $this->assertEquals('1:08', $Status1->getMessageId());
        $this->assertFalse($Status1->hasCanonicalId());
        $this->assertFalse($Status1->mustRemove());
        $this->assertFalse($Status1->canRetry());

        $Response2 = Response::initializeByString('id=1:2342
registration_id=32');
        $this->assertInstanceOf(Status::class, $Response2->getResults()[0]);
        $Status2 = $Response2->getResults()[0];
        $this->assertEquals('32', $Status2->getCanonicalId());
        $this->assertEmpty($Status2->getError());
        $this->assertEquals('1:08', $Status1->getMessageId());
        $this->assertFalse($Status1->hasCanonicalId());
        $this->assertFalse($Status1->mustRemove());
        $this->assertFalse($Status1->canRetry());
    }

    public function testJsonInitialization() {
        Response::$type = PayloadMessage::TYPE_JSON;
        $Response1 = Response::initializeByString('{ "multicast_id": 108,
  "success": 1,
  "failure": 0,
  "canonical_ids": 0,
  "results": [
    { "message_id": "1:08" }
  ]
}');
        $this->assertInstanceOf(Status::class, $Response1->getResults()[0]);
        $Status1 = $Response1->getResults()[0];
        $this->assertEmpty($Status1->getCanonicalId());
        $this->assertEmpty($Status1->getError());
        $this->assertEquals('1:08', $Status1->getMessageId());
        $this->assertFalse($Status1->hasCanonicalId());
        $this->assertFalse($Status1->mustRemove());
        $this->assertFalse($Status1->canRetry());

        $Response2 = Response::initializeByString('{ "multicast_id": 216,
  "success": 3,
  "failure": 3,
  "canonical_ids": 1,
  "results": [
    { "message_id": "1:0408" },
    { "error": "Unavailable" },
    { "error": "InvalidRegistration" },
    { "message_id": "1:1516" },
    { "message_id": "1:2342", "registration_id": "32" },
    { "error": "NotRegistered"}
  ]
}');
        $this->assertInstanceOf(Status::class, $Response2->getResults()[0]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[1]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[2]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[3]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[4]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[5]);

        $Status21 = $Response2->getResults()[0];
        $this->assertEmpty($Status21->getCanonicalId());
        $this->assertEmpty($Status21->getError());
        $this->assertEquals('1:0408', $Status21->getMessageId());
        $this->assertFalse($Status21->hasCanonicalId());
        $this->assertFalse($Status21->mustRemove());
        $this->assertFalse($Status21->canRetry());

        $Status22 = $Response2->getResults()[1];
        $this->assertEmpty($Status22->getCanonicalId());
        $this->assertEquals(Status::STATUS_UNAVAILABLE, $Status22->getError());
        $this->assertEmpty($Status22->getMessageId());
        $this->assertFalse($Status22->hasCanonicalId());
        $this->assertFalse($Status22->mustRemove());
        $this->assertTrue($Status22->canRetry());

        $Status23 = $Response2->getResults()[2];
        $this->assertEmpty($Status23->getCanonicalId());
        $this->assertEquals(Status::STATUS_INVALID_REGISTRATION, $Status23->getError());
        $this->assertEmpty($Status23->getMessageId());
        $this->assertFalse($Status23->hasCanonicalId());
        $this->assertFalse($Status23->mustRemove());
        $this->assertFalse($Status23->canRetry());

        $Status24 = $Response2->getResults()[3];
        $this->assertEmpty($Status24->getCanonicalId());
        $this->assertEmpty($Status24->getError());
        $this->assertEquals('1:1516', $Status24->getMessageId());
        $this->assertFalse($Status24->hasCanonicalId());
        $this->assertFalse($Status24->mustRemove());
        $this->assertFalse($Status24->canRetry());

        $Status25 = $Response2->getResults()[4];
        $this->assertEquals('32', $Status25->getCanonicalId());
        $this->assertEmpty($Status25->getError());
        $this->assertEquals('1:2342', $Status25->getMessageId());
        $this->assertTrue($Status25->hasCanonicalId());
        $this->assertFalse($Status25->mustRemove());
        $this->assertFalse($Status25->canRetry());

        $Status26 = $Response2->getResults()[5];
        $this->assertEmpty($Status26->getCanonicalId());
        $this->assertEquals(Status::STATUS_NOT_REGISTERED, $Status26->getError());
        $this->assertEmpty($Status26->getMessageId());
        $this->assertFalse($Status26->hasCanonicalId());
        $this->assertTrue($Status26->mustRemove());
        $this->assertFalse($Status26->canRetry());
    }
}
