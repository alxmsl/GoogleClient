<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
