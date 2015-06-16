<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Test\Google\GCM;

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
}
