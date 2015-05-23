<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
