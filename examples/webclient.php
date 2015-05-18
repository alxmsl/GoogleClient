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

include '../source/Autoloader.php';
include '../vendor/alxmsl/network/source/Autoloader.php';

use alxmsl\Google\OAuth2\Response\Token;
use alxmsl\Google\OAuth2\WebServerApplication;

// Define client identification
const CLIENT_ID       = 'my-client@id',
      CLIENT_SECRET   = 'clientsecret';

$shortOptions = 'c::';
$longOptions = array(
    'code::',
);
$options = getopt($shortOptions, $longOptions);
$code = null;
if (isset($options['c'])) {
    $code = $options['c'];
} else if (isset($options['code'])) {
    $code = $options['code'];
}

// Create new client
$Client = new WebServerApplication();
$Client->setClientId(CLIENT_ID)
    ->setClientSecret(CLIENT_SECRET)
    ->setRedirectUri('http://example.com/oauth2callback');

if (is_null($code)) {
    // Create authorization url
    $url = $Client->createAuthUrl(array(
            'https://www.googleapis.com/auth/androidpublisher',
        ), ''
        , WebServerApplication::RESPONSE_TYPE_CODE
        , WebServerApplication::ACCESS_TYPE_OFFLINE
        // Use FORCE to get new refresh token for offline access type
        , WebServerApplication::APPROVAL_PROMPT_FORCE);
    var_dump($url);
} else {
    var_dump($code);
    // Get access token
    $Token = $Client->authorizeByCode($code);
    var_dump($Token);

    if ($Token instanceof Token) {
        // Get refresh token
        if (!$Token->isOnline()) {
            $Refreshed = $Client->refresh($Token->getRefreshToken());
            var_dump($Refreshed);
        }

        $revoked = $Client->revoke($Token->getAccessToken());
        if ($revoked) {
            var_dump('token ' . $Token->getAccessToken() . ' was revoke');
        } else {
            var_dump('error on revoke token ' . $Token->getAccessToken());
        }
    }
}
