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
