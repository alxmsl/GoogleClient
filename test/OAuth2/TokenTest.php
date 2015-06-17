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
