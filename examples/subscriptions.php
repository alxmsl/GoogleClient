<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * Google subscriptions check
 * @author alxmsl
 * @date 1/24/13
 */

include '../source/Autoloader.php';
include '../vendor/alxmsl/network/source/Autoloader.php';

use alxmsl\Google\OAuth2\WebServerApplication;
use alxmsl\Google\Purchases\Purchases;

// Define client identification
const CLIENT_ID     = 'my client id',
      CLIENT_SECRET = 'my client secret code',
      REDIRECT_URL  = 'my redirect url';

// Create new client
$Client = new WebServerApplication();
$Client->setClientId(CLIENT_ID)
    ->setClientSecret(CLIENT_SECRET)
    ->setRedirectUri(REDIRECT_URL);

// Create authorization url
$url = $Client->createAuthUrl(array('https://www.googleapis.com/auth/androidpublisher')
    , ''
    , WebServerApplication::RESPONSE_TYPE_CODE
    , WebServerApplication::ACCESS_TYPE_OFFLINE);
echo $url . "\n";
die;

// Get client authorization code by following authorization url
const CLIENT_CODE = 'authorization code';

// Get access token
$Token = $Client->authorizeByCode(CLIENT_CODE);
var_dump($Token);

// Check subscription
const PACKAGE_NAME = 'com.myapp',
      PRODUCT      = 'myapp.subscription.1',
      SUBSCRIPTION = 'my subscription identifier';

$Purchases = new Purchases();
$Purchases->setAccessToken($Token->getAccessToken())
    ->setPackage(PACKAGE_NAME);
$Subscription = $Purchases->get(PRODUCT, SUBSCRIPTION);
var_dump($Subscription);

// Refresh token
sleep($Token->getExpiresIn());
$RefreshedToken = $Client->refresh($Token->getRefreshToken());

// Check subscription by unauthorized token
$Subscription = $Purchases->get(PRODUCT, SUBSCRIPTION);
var_dump($Subscription);

// Check subscription by refreshed token
$Purchases->setAccessToken($RefreshedToken->getAccessToken());
$Subscription = $Purchases->get(PRODUCT, SUBSCRIPTION);
var_dump($Subscription);
