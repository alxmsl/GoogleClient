<?php
/**
 * Google subscriptions check
 * @author alxmsl
 * @date 1/24/13
 */

include '../source/Autoloader.php';
include '../lib/Network/source/Autoloader.php';

// Define client identification
const   ACCESS_TOKEN = 'access token',
        PACKAGE_NAME = 'com.some.thing';

$Client = new \Google\Client\Purchases\Purchases();
$Client->setAccessToken(ACCESS_TOKEN)
    ->setPackage(PACKAGE_NAME);

// Get user subscription data
$Subscription = $Client->get('some.thing.subscription.1', 'subscription token');
var_dump($Subscription);