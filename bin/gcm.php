<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
