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
use alxmsl\Google\AndroidPublisher\InAppProducts\Client;

$accessToken = '';
$packageName = '';
$productId   = '';

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
$Command->appendParameter(new Option('product', 'r', 'product id', Option::TYPE_STRING, true)
    , function($name, $value) use (&$productId) {
        $productId = $value;
    });

try {
    $Command->parse(true);
    $Client = new Client();
    $Client->setPackage($packageName)
        ->setAccessToken($accessToken);
    $Resource = $Client->get($productId);
    printf("%s\n", (string) $Resource);
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}
