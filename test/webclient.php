<?php
/**
 * Google web server authorization
 * @author alxmsl
 * @date 1/24/13
 */

include '../source/Autoloader.php';
include '../lib/Network/source/Autoloader.php';

// Define client identification
const   CLIENT_ID       = 'my client id',
        CLIENT_SECRET   = 'my client secret code';

// Create new client
$Client = new \Google\Client\WebServerClient();
$Client->setClientId(CLIENT_ID)
    ->setClientSecret(CLIENT_SECRET)
    ->setRedirectUri('http://example.com/oauth2callback');

// Create authorization url
$url = $Client->createAuthUrl(array(
    'https://www.googleapis.com/auth/userinfo.email',
    'https://www.googleapis.com/auth/userinfo.profile',
), '', \Google\Client\Client::RESPONSE_TYPE_CODE, \Google\Client\Client::ACCESS_TYPE_OFFLINE);
var_dump($url);

// Get access token
$Token = $Client->getAccessToken('4/E-sLNekvMUD99lYT39XYZBWRwGaK.UiZFTQZSjAYcsNf4jSFBMpaIucRNeQI');
var_dump($Token);