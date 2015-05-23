<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * Script for Google API authorization
 * @author alxmsl
 */

include __DIR__ . '/../vendor/autoload.php';

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Exception\RequiredOptionException;
use alxmsl\Cli\Option;
use alxmsl\Google\AndroidPublisher\Purchases\Subscription\SubscriptionsClient;

$accessToken    = '';
$expireTime     = 0;
$desireTime     = 0;
$packageName    = '';
$subscriptionId = '';
$token          = '';

$Command = new CommandPosix();
$Command->appendHelpParameter('show help');
$Command->appendParameter(new Option('access', 'a', 'access token', Option::TYPE_STRING, true)
    , function($name, $value) use (&$accessToken) {
        $accessToken = $value;
    });
$Command->appendParameter(new Option('expire', 'e', 'expire timestamp, milliseconds', Option::TYPE_STRING, true)
    , function($name, $value) use (&$expireTime) {
        $expireTime = (int) $value;
    });
$Command->appendParameter(new Option('desire', 'd', 'desire timestamp, milliseconds', Option::TYPE_STRING, true)
    , function($name, $value) use (&$desireTime) {
        $desireTime = (int) $value;
    });
$Command->appendParameter(new Option('package', 'p', 'package name', Option::TYPE_STRING)
    , function($name, $value) use (&$packageName) {
        $packageName = $value;
    });
$Command->appendParameter(new Option('subscription', 's', 'subscription id', Option::TYPE_STRING, true)
    , function($name, $value) use (&$subscriptionId) {
        $subscriptionId = $value;
    });
$Command->appendParameter(new Option('token', 't', 'purchase token', Option::TYPE_STRING, true)
    , function($name, $value) use (&$token) {
        $token = $value;
    });

try {
    $Command->parse(true);
    $Client = new SubscriptionsClient();
    $Client->setPackage($packageName)
        ->setAccessToken($accessToken);
    $newExpireTime = $Client->defer($subscriptionId, $expireTime, $desireTime, $token);
    printf("new expiration timestamp: %s\n", $newExpireTime);
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}
