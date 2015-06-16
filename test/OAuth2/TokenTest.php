<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Test\Google\OAuth2;

use alxmsl\Google\OAuth2\Response\Token;
use OutOfBoundsException;
use PHPUnit_Framework_TestCase;

/**
 * Token class tests
 * @author alxmsl
 */
final class TokenTest extends PHPUnit_Framework_TestCase {
    public function testToken() {
        $Token = Token::initializeByString('{
            "access_token": "lalala",
            "expires_in": 3600,
            "token_type": "Bearer"
        }');

        $this->assertEquals('lalala', $Token->getAccessToken());
        $this->assertEquals(3600, $Token->getExpiresIn());
        $this->assertEquals(Token::TYPE_BEARER, $Token->getTokenType());
        $this->assertEmpty($Token->getIdToken());
        $this->assertTrue($Token->isOnline());
        try {
            $this->assertEmpty($Token->getRefreshToken());
            $this->fail();
        } catch (OutOfBoundsException $Ex) {}
    }

    public function testTokenType() {
        $Token = Token::initializeByString('{
            "access_token": "lalala",
            "expires_in": 3600,
            "token_type": "WTF"
        }');
        $this->assertEquals(Token::TYPE_UNKNOWN, $Token->getTokenType());
    }

    public function testIdToken() {
        $Token = Token::initializeByString('{
            "access_token": "lalala",
            "expires_in": 3600,
            "token_type": "Bearer",
            "id_token": "someIDTOken"
        }');
        $this->assertEquals('someIDTOken', $Token->getIdToken());
    }

    public function testRefreshToken() {
        $Token = Token::initializeByString('{
            "access_token": "lalala",
            "expires_in": 3600,
            "token_type": "Bearer",
            "refresh_token": "someREFREshTOken"
        }');
        $this->assertEquals('someREFREshTOken', $Token->getRefreshToken());
        $this->assertFalse($Token->isOnline());
    }
}
