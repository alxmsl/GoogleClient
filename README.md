GoogleClient
============

Google services API library

Installation
-------

For install library you need to modify your composer configuration file

    "alxmsl/network": "v1.0.1"

And just run installation command

    composer.phar install

Web Server Applications authorization example
-------

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
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
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

Inapp purchases workflow example
-------

    use alxmsl\Google\InAppPurchases\InAppPurchases;

    // Check subscription
    const PACKAGE_NAME = 'com.myapp',
          PRODUCT      = 'myapp.product.1',
          INAPP        = 'my inapp token';

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
        $Purchases = new InAppPurchases();
        $Purchases->setPackage(PACKAGE_NAME)
            ->setAccessToken($token);
        $Resource = $Purchases->get(PRODUCT, INAPP);
        var_dump($Resource);
    } else {
        die ('required parameter \'token\' not present' . "\n");
    }

Subscriptions workflow example
-------

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

License
-------
Copyright © 2014 Alexey Maslov <alexey.y.maslov@gmail.com>
This work is free. You can redistribute it and/or modify it under the
terms of the Do What The Fuck You Want To Public License, Version 2,
as published by Sam Hocevar. See the COPYING file for more details.
