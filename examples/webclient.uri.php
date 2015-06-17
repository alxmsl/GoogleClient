<?php
/**
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
 *
 * Google web server authorization uri example
 * @author alxmsl
 * @date 1/24/13
 */

include '../vendor/autoload.php';

use alxmsl\Google\OAuth2\Response\Token;
use alxmsl\Google\OAuth2\WebServerApplication;

// Define client identification
const CLIENT_ID     = 'my-client@id',
      CLIENT_SECRET = 'clientsecret',
      REDIRECT_URI  = 'http://example.com/oauth2callback';

// Create new client
$Client = new WebServerApplication();
$Client->setClientId(CLIENT_ID)
    ->setClientSecret(CLIENT_SECRET)
    ->setRedirectUri(REDIRECT_URI);

// Create authorization url
$url = $Client->createAuthUrl([
        'https://www.googleapis.com/auth/androidpublisher',
    ]
    , ''
    , WebServerApplication::RESPONSE_TYPE_CODE
    , WebServerApplication::ACCESS_TYPE_OFFLINE
    // Use FORCE to get new refresh token for offline access type
    , WebServerApplication::APPROVAL_PROMPT_FORCE);
var_dump($url);
