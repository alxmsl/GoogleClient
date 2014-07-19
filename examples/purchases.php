<?php
/**
 * Google subscriptions check
 * @author alxmsl
 * @date 1/24/13
 */

include '../source/Autoloader.php';
include '../vendor/alxmsl/network/source/Autoloader.php';

use alxmsl\Google\Purchases\Purchases;

// Define client identification
const   ACCESS_TOKEN = 'access token',
        PACKAGE_NAME = 'com.some.thing';

$Client = new Purchases();
$Client->setPackage(PACKAGE_NAME)
    ->setAccessToken(ACCESS_TOKEN);

// Get user subscription data
$Subscription = $Client->get('some.thing.subscription.1', 'subscription token');
var_dump($Subscription);
