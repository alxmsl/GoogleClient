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
