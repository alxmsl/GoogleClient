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
