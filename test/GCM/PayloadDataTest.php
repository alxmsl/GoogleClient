<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
