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

use alxmsl\Google\GCM\Exception\GCMFormatException;
use alxmsl\Google\GCM\Message\PayloadMessage;
use alxmsl\Google\GCM\Response\Response;
use alxmsl\Google\GCM\Response\Status;
use PHPUnit_Framework_TestCase;

/**
 * Response class test
 * @author alxmsl
 */
final class ResponseTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Response = new Response();
        $this->assertEquals(0, $Response->getCanonicalIdsCount());
        $this->assertEquals(0, $Response->getFailureCount());
        $this->assertEmpty($Response->getMulticastId());
        $this->assertEquals([], $Response->getResults());
        $this->assertEquals(0, $Response->getSuccessCount());
    }

    public function testProperties() {
        $Response = new Response();
        $Response->setCanonicalIdsCount(2.45);
        $this->assertSame(2, $Response->getCanonicalIdsCount());
        $Response->setFailureCount('123hui');
        $this->assertSame(123, $Response->getFailureCount());
        $Response->setMulticastId(765,55);
        $this->assertSame('765', $Response->getMulticastId());
        $Response->setSuccessCount(9);
        $this->assertEquals(9, $Response->getSuccessCount());
    }

    public function testPlainResponse() {
        Response::$type = PayloadMessage::TYPE_PLAIN;

        $Response1 = Response::initializeByString('id=1:08');
        $this->assertEquals(0, $Response1->getCanonicalIdsCount());
        $this->assertEquals(0, $Response1->getFailureCount());
        $this->assertEquals(1, $Response1->getSuccessCount());
        $this->assertCount(1, $Response1->getResults());
        $this->assertInstanceOf(Status::class, $Response1->getResults()[0]);

        $Response2 = Response::initializeByString('id=1:2342
registration_id=32');
        $this->assertEquals(1, $Response2->getCanonicalIdsCount());
        $this->assertEquals(0, $Response2->getFailureCount());
        $this->assertEquals(1, $Response2->getSuccessCount());
        $this->assertCount(1, $Response2->getResults());
        $this->assertInstanceOf(Status::class, $Response2->getResults()[0]);

        try {
            Response::initializeByString('id=1:2342
something');
            $this->fail();
        } catch (GCMFormatException $Ex) {}

        $Response3 = Response::initializeByString('Error=error:MissingRegistration');
        $this->assertEquals(0, $Response3->getCanonicalIdsCount());
        $this->assertEquals(1, $Response3->getFailureCount());
        $this->assertEquals(0, $Response3->getSuccessCount());
        $this->assertCount(1, $Response3->getResults());
        $this->assertInstanceOf(Status::class, $Response3->getResults()[0]);
        $this->assertEquals('error:MissingRegistration', $Response3->getResults()[0]->getError());
    }

    public function testJsonResponse() {
        Response::$type = PayloadMessage::TYPE_JSON;

        $Response1 = Response::initializeByString('{ "multicast_id": 108,
  "success": 1,
  "failure": 0,
  "canonical_ids": 0,
  "results": [
    { "message_id": "1:08" }
  ]
}');
        $this->assertEquals(0, $Response1->getCanonicalIdsCount());
        $this->assertEquals(0, $Response1->getFailureCount());
        $this->assertEquals(1, $Response1->getSuccessCount());
        $this->assertCount(1, $Response1->getResults());
        $this->assertInstanceOf(Status::class, $Response1->getResults()[0]);

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
        $this->assertEquals(1, $Response2->getCanonicalIdsCount());
        $this->assertEquals(3, $Response2->getFailureCount());
        $this->assertEquals(3, $Response2->getSuccessCount());
        $this->assertCount(6, $Response2->getResults());
        $this->assertInstanceOf(Status::class, $Response2->getResults()[0]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[1]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[2]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[3]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[4]);
        $this->assertInstanceOf(Status::class, $Response2->getResults()[5]);
    }

    public function testUnknownTypeResponse() {
        Response::$type = 88;
        try {
            Response::initializeByString('{ "multicast_id": 108,
      "success": 1,
      "failure": 0,
      "canonical_ids": 0,
      "results": [
        { "message_id": "1:08" }
      ]
    }');
            $this->fail();
        } catch (GCMFormatException $Ex) {}
    }
}
