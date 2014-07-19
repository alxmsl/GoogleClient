<?php
/**
 * GCM message sending test
 * @author alxmsl
 * @date 5/28/13
 */

include '../source/Autoloader.php';
include '../vendor/alxmsl/network/source/Autoloader.php';

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
