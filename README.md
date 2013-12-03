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

Web Server Applications authorization example
-------

    include '../source/Autoloader.php';
    include '../lib/Network/source/Autoloader.php';
    
    // Define client identification
    const   CLIENT_ID       = 'my-client@id',
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
    $Client = new \Google\Client\OAuth2\WebServerApplication();
    $Client->setClientId(CLIENT_ID)
        ->setClientSecret(CLIENT_SECRET)
        ->setRedirectUri('http://example.com/oauth2callback');
    
    if (is_null($code)) {
        // Create authorization url
        $url = $Client->createAuthUrl(array(
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ), ''
            , \Google\Client\OAuth2\WebServerApplication::RESPONSE_TYPE_CODE
            , \Google\Client\OAuth2\WebServerApplication::ACCESS_TYPE_OFFLINE
            // Use FORCE to get new refresh token for offline access type
            , \Google\Client\OAuth2\WebServerApplication::APPROVAL_PROMPT_FORCE);
        var_dump($url);
    } else {
        var_dump($code);
        // Get access token
        $Token = $Client->authorizeByCode($code);
        var_dump($Token);
    
        if ($Token instanceof \Google\Client\OAuth2\Response\Token) {
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

Inapp purchases workflow example
-------

    include '../source/Autoloader.php';
    include '../lib/Network/source/Autoloader.php';

    // Check subscription
    const   PACKAGE_NAME    = 'com.myapp',
            PRODUCT         = 'myapp.product.1',
            INAPP           = 'my inapp token';
    
    $shortOptions = 't::';
    $longOptions = array(
        'token::',
    );
    $options = getopt($shortOptions, $longOptions);
    $token = null;
    if (isset($options['t'])) {
        $token = $options['t'];
    } else if (isset($options['token'])) {
        $token = $options['token'];
    }
    
    if (!is_null($token)) {
        $Purchases = new \Google\Client\InAppPurchases\InAppPurchases();
        $Purchases->setPackage(PACKAGE_NAME)
            ->setAccessToken($token);
        $Resource = $Purchases->get(PRODUCT, INAPP);
        var_dump($Resource);
    } else {
        die ('required parameter \'token\' not present' . "\n");
    }

Subscriptions workflow example
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
