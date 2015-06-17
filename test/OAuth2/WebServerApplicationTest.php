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
use alxmsl\Google\OAuth2\WebServerApplication;
use PHPUnit_Framework_TestCase;

/**
 * WebServerApplication class tests
 * @author alxmsl
 */
final class WebServerApplicationTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Client = new WebServerApplication();
        $this->assertNull($Client->getToken());
    }

    public function testProperties() {
        $Token = Token::initializeByString('{
            "access_token": "lalala",
            "expires_in": 3600,
            "token_type": "Bearer"
        }');

        $Client = new WebServerApplication();
        $Client->setToken($Token);

        $this->assertEquals($Token, $Client->getToken());
        $this->assertEquals('lalala', $Client->getAccessToken());
    }

    public function testCreateAuthUrl() {
        $Client = new WebServerApplication();

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=&access_type=online&approval_prompt=auto
EOD
            , $Client->createAuthUrl([]));

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=online&approval_prompt=auto
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ]));

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=online&approval_prompt=auto
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], ''));

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=online&approval_prompt=auto&state=SOMEstate
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], 'SOMEstate'));

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=online&approval_prompt=auto
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], '', WebServerApplication::RESPONSE_TYPE_CODE));

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=online&approval_prompt=auto
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], '', WebServerApplication::RESPONSE_TYPE_CODE, WebServerApplication::ACCESS_TYPE_ONLINE));

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=offline&approval_prompt=auto
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], '', WebServerApplication::RESPONSE_TYPE_CODE, WebServerApplication::ACCESS_TYPE_OFFLINE));

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=offline&approval_prompt=auto
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], '', WebServerApplication::RESPONSE_TYPE_CODE, WebServerApplication::ACCESS_TYPE_OFFLINE
                , WebServerApplication::APPROVAL_PROMPT_AUTO));

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=offline&approval_prompt=force
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], '', WebServerApplication::RESPONSE_TYPE_CODE, WebServerApplication::ACCESS_TYPE_OFFLINE
                , WebServerApplication::APPROVAL_PROMPT_FORCE));

        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=offline&approval_prompt=force&login_hint=my_hint
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], '', WebServerApplication::RESPONSE_TYPE_CODE, WebServerApplication::ACCESS_TYPE_OFFLINE
                , WebServerApplication::APPROVAL_PROMPT_FORCE, 'my_hint'));

        $Client->setClientId('ClieNTID');
        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=ClieNTID&redirect_uri=&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=offline&approval_prompt=force&login_hint=my_hint
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], '', WebServerApplication::RESPONSE_TYPE_CODE, WebServerApplication::ACCESS_TYPE_OFFLINE
                , WebServerApplication::APPROVAL_PROMPT_FORCE, 'my_hint'));

        $Client->setRedirectUri('http:/example.com/oauth2callback');
        $this->assertEquals(<<<'EOD'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=ClieNTID&redirect_uri=http%3A%2Fexample.com%2Foauth2callback&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher&access_type=offline&approval_prompt=force&login_hint=my_hint
EOD
            , $Client->createAuthUrl([
                'https://www.googleapis.com/auth/androidpublisher',
            ], '', WebServerApplication::RESPONSE_TYPE_CODE, WebServerApplication::ACCESS_TYPE_OFFLINE
                , WebServerApplication::APPROVAL_PROMPT_FORCE, 'my_hint'));
    }
}
