<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * GCM message sending example
 * @author alxmsl
 * @date 5/28/13
 */

include '../vendor/autoload.php';

use alxmsl\Google\GCM\Client;
use alxmsl\Google\GCM\Message\PayloadData;
use alxmsl\Google\GCM\Message\PayloadMessage;

// Create new payload class
final class NewPayloadData extends PayloadData {
    protected function getDataFields() {
        return array(
            'test' => 'test_01',
        );
    }
}

// Create payload instance
$Data = new NewPayloadData();

// Create and initialize message instance
$Message = new PayloadMessage();
$Message->setRegistrationIds('DeV1CeT0kEN')
    ->setType(PayloadMessage::TYPE_JSON)
    ->setData($Data);

// Create GCM client
$Client = new Client();
$Client->getRequest()->setConnectTimeout(60);
$Client->setAuthorizationKey('aUTH0R1Z4t1oNKEy');

// ...and send the message
$Response = $Client->send($Message);
var_dump($Response);
