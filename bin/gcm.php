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
 * Script for GCM notification sending
 * @author alxmsl
 */

include __DIR__ . '/../vendor/autoload.php';

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Exception\RequiredOptionException;
use alxmsl\Cli\Option;
use alxmsl\Google\GCM\Client;
use alxmsl\Google\GCM\Message\CustomPayloadData;
use alxmsl\Google\GCM\Message\PayloadMessage;

$data = '';
$id   = '';
$key  = '';

$Command = new CommandPosix();
$Command->appendHelpParameter('show help');
$Command->appendParameter(new Option('data', 'd', 'payload data', Option::TYPE_STRING)
    , function($name, $value) use (&$data) {
        $data = $value;
    });
$Command->appendParameter(new Option('id', 'i', 'device registration id', Option::TYPE_STRING, true)
    , function($name, $value) use (&$id) {
        $id = $value;
    });
$Command->appendParameter(new Option('key', 'k', 'authorization key', Option::TYPE_STRING, true)
    , function($name, $value) use (&$key) {
        $key = $value;
    });
try {
    $Command->parse(true);

    // Create payload instance
    $Data = new CustomPayloadData($data);

    // Create and initialize message instance
    $Message = new PayloadMessage();
    $Message->setRegistrationIds($id)
        ->setType(PayloadMessage::TYPE_JSON)
        ->setData($Data);

    // Create GCM client
    $Client = new Client();
    $Client->getRequest()->setConnectTimeout(60)
        ->setSslVersion(6);
    $Client->setAuthorizationKey($key);

    // ...and send the message
    $Response = $Client->send($Message);
    printf(<<<'EOD'
    success: %s
    failure: %s
EOD
        , $Response->getSuccessCount()
        , $Response->getFailureCount());
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}
