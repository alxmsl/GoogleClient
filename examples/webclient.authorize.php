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
 * Google web server authorization example
 * @author alxmsl
 * @date 1/24/13
 */

include '../vendor/autoload.php';

use alxmsl\Google\OAuth2\Response\Token;
use alxmsl\Google\OAuth2\WebServerApplication;

// Define client identification
const CLIENT_ID     = 'my-client@id',
      CLIENT_SECRET = 'clientsecret';

// Create new client
$Client = new WebServerApplication();
$Client->setClientId(CLIENT_ID)
    ->setClientSecret(CLIENT_SECRET);

// Get access token
$Token = $Client->authorizeByCode($code);
if ($Token instanceof Token) {
    var_dump($Token);

    // Get refresh token
    $Refreshed = $Client->refresh($Token->getRefreshToken());
    var_dump($Refreshed);

    $revoked = $Client->revoke($Token->getAccessToken());
    if ($revoked) {
        printf('token %s was revoke', $Token->getAccessToken());
    } else {
        printf('error on revoke token %s', $Token->getAccessToken());
    }
} else {
    var_dump($Token);
}
