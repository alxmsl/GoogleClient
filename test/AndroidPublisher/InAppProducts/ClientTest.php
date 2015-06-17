<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Test\GoogleClient\AndroidPublisher\InAppProducts;

use alxmsl\Google\AndroidPublisher\InAppProducts\Client;
use PHPUnit_Framework_TestCase;
use UnexpectedValueException;

/**
 * In-App Products Client test class
 * @author alxmsl
 */
final class ClientTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Client = new Client();
        $this->assertEmpty($Client->getPackage());
    }

    public function testGet() {
        $Client = new Client();
        try {
            $Client->get('');
            $this->fail();
        } catch (UnexpectedValueException $Ex) {}
    }
}
