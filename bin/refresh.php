<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
