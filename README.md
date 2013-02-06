GoogleClient
============

Google OAuth2.0 authorization library

Installation
-------

For install library completely, you need to update submodules after checkout. For example:

    git clone git@github.com:alxmsl/GoogleClient.git temp
    && cd temp
    && git submodule init
    && git submodule update

Usage example
-------

    include '../source/Autoloader.php';
    include '../lib/Network/source/Autoloader.php';

    // Define client identification
    const   CLIENT_ID       = 'my client id',
            CLIENT_SECRET   = 'my client secret code';

    // Create new webserver applications client
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

