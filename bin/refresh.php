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
 * Script for Google API access token refreshing
 * @author alxmsl
 */

include __DIR__ . '/../vendor/autoload.php';

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Exception\RequiredOptionException;
use alxmsl\Cli\Option;
use alxmsl\Google\OAuth2\WebServerApplication;

$clientId     = '';
$clientSecret = '';
$refreshToken = '';

$Command = new CommandPosix();
$Command->appendHelpParameter('show help');
$Command->appendParameter(new Option('client', 'c', 'client id', Option::TYPE_STRING, true)
    , function($name, $value) use (&$clientId) {
        $clientId = $value;
    });
$Command->appendParameter(new Option('secret', 'e', 'client secret', Option::TYPE_STRING, true)
    , function($name, $value) use (&$clientSecret) {
        $clientSecret = $value;
    });
$Command->appendParameter(new Option('token', 't', 'refresh token', Option::TYPE_STRING, true)
    , function($name, $value) use (&$refreshToken) {
        $refreshToken = $value;
    });

try {
    $Command->parse(true);
    // Create new client
    $Client = new WebServerApplication();
    $Client->setClientId($clientId)
        ->setClientSecret($clientSecret);

    // Get refreshed authorization token
    $Token = $Client->refresh($refreshToken);
    printf("%s\n", (string) $Token);
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}
