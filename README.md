GoogleClient
============

Google OAuth2.0 authorization library

Installation
-------

For install library completely, you need to update submodules after checkout. For example:

    git clone git://github.com/alxmsl/GoogleClient.git temp
    && cd temp
    && git submodule init
    && git submodule update

Authorization example
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

Subscriptions example
-------

    include '../source/Autoloader.php';
    include '../lib/Network/source/Autoloader.php';
    
    // Define client identification
    const   CLIENT_ID       = 'my client id',
            CLIENT_SECRET   = 'my client secret code',
            REDIRECT_URL    = 'my redirect url';
    
    // Create new client
    $Client = new \Google\Client\OAuth2\WebServerApplication();
    $Client->setClientId(CLIENT_ID)
        ->setClientSecret(CLIENT_SECRET)
        ->setRedirectUri(REDIRECT_URL);
    
    // Create authorization url
    $url = $Client->createAuthUrl(array('https://www.googleapis.com/auth/androidpublisher')
        , ''
        , \Google\Client\OAuth2\WebServerApplication::RESPONSE_TYPE_CODE
        , \Google\Client\OAuth2\WebServerApplication::ACCESS_TYPE_OFFLINE);
    echo $url . "\n";
    
    // Get client authorization code by following authorization url
    const   CLIENT_CODE = 'authorization code';
    
    // Get access token
    $Token = $Client->authorizeByCode(CLIENT_CODE);
    var_dump($Token);
    
    // Check subscription
    const   PACKAGE_NAME = 'com.myapp',
            PRODUCT      = 'myapp.subscription.1',
            SUBSCRIPTION = 'my subscription identifier';
    
    $Purchases = new \Google\Client\Purchases\Purchases();
    $Purchases->setAccessToken($Token->getAccessToken())
        ->setPackage(PACKAGE_NAME);
    $Subscription = $Purchases->get(PRODUCT, SUBSCRIPTION);
    var_dump($Subscription);
    
    // Refresh token
    sleep($Token->getExpiresIn());
    $RefreshedToken = $Client->refresh($Token->getRefreshToken());
    
    // Check subscription by refreshed token
    $Subscription = $Purchases->get(PRODUCT, SUBSCRIPTION);
    var_dump($Subscription);
