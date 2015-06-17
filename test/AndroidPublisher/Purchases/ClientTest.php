<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
