<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Test\Google\OAuth2;

use alxmsl\Google\OAuth2\Client;
use PHPUnit_Framework_TestCase;

/**
 * Tests for abstract Client class
 * @author alxmsl
 */
final class ClientTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        /** @var Client $Mock */
        $Mock = $this->getMockForAbstractClass(Client::class);
        $this->assertEmpty($Mock->getAccessToken());
        $this->assertEmpty($Mock->getClientId());
        $this->assertEmpty($Mock->getClientSecret());
        $this->assertEmpty($Mock->getRedirectUri());
        $this->assertEquals(0, $Mock->getConnectTimeout());
        $this->assertEquals(0, $Mock->getRequestTimeout());
    }

    public function testProperties() {
        /** @var Client $Mock */
        $Mock = $this->getMockForAbstractClass(Client::class);

        $Mock->setAccessToken('accesssss_tokkken');
        $this->assertEquals('accesssss_tokkken', $Mock->getAccessToken());

        $Mock->setClientId('clientIdentifier');
        $this->assertEquals('clientIdentifier', $Mock->getClientId());

        $Mock->setClientSecret('ClienTSECRET');
        $this->assertEquals('ClienTSECRET', $Mock->getClientSecret());

        $Mock->setRedirectUri('reDIRECTuri');
        $this->assertEquals('reDIRECTuri', $Mock->getRedirectUri());

        $Mock->setConnectTimeout(30);
        $this->assertEquals(30, $Mock->getConnectTimeout());

        $Mock->setRequestTimeout(60);
        $this->assertEquals(60, $Mock->getRequestTimeout());
    }

    public function testPropertiesExtremely() {
        /** @var Client $Mock */
        $Mock = $this->getMockForAbstractClass(Client::class);

        $Mock->setAccessToken(01256);
        $this->assertSame('686', $Mock->getAccessToken());

        $Mock->setClientId(8,445);
        $this->assertSame('8', $Mock->getClientId());

        $Mock->setClientSecret(18.5);
        $this->assertSame('18.5', $Mock->getClientSecret());

        $Mock->setRedirectUri(1e2);
        $this->assertEquals('100', $Mock->getRedirectUri());

        $Mock->setConnectTimeout(0,44);
        $this->assertEquals(0, $Mock->getConnectTimeout());

        $Mock->setRequestTimeout('2.333petrovich');
        $this->assertEquals(2, $Mock->getRequestTimeout());
    }
}
