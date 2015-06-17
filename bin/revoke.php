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

$token = '';

$Command = new CommandPosix();
$Command->appendHelpParameter('show help');
$Command->appendParameter(new Option('token', 't', 'revoked token', Option::TYPE_STRING, true)
    , function($name, $value) use (&$token) {
        $token = $value;
    });

try {
    $Command->parse(true);
    $Client  = new WebServerApplication();
    $revoked = $Client->revoke($token);
    if ($revoked) {
        printf("token %s revoked\n", $token);
    } else {
        printf("token %s was not revoke\n", $token);
    }
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}
