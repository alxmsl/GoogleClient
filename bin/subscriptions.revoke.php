<?php
/**
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Script for Google API authorization
 * @author alxmsl
 */

include __DIR__ . '/../vendor/autoload.php';

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Exception\RequiredOptionException;
use alxmsl\Cli\Option;
use alxmsl\Google\AndroidPublisher\Purchases\Subscriptions\SubscriptionsClient;

$accessToken    = '';
$packageName    = '';
$subscriptionId = '';
$token          = '';

$Command = new CommandPosix();
$Command->appendHelpParameter('show help');
$Command->appendParameter(new Option('access', 'a', 'access token', Option::TYPE_STRING, true)
    , function($name, $value) use (&$accessToken) {
        $accessToken = $value;
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
    $Resource = $Client->revokeSubscription($subscriptionId, $token);
    printf("subscription %s revoked\n", $subscriptionId);
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}
