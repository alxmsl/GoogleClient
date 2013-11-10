<?php
/**
 * GCM message sending test
 * @author alxmsl
 * @date 5/28/13
 */

include '../source/Autoloader.php';
include '../lib/Network/source/Autoloader.php';

// Create new payload class
final class NewPayloadData extends \Google\Client\GCM\Message\PayloadData {
    protected function getDataFields() {
        return array(
            'test' => 'test_01',
        );
    }
}

// Create payload instance
$Data = new NewPayloadData();

// Create and initialize message instance
$Message = new \Google\Client\GCM\Message\PayloadMessage();
$Message->setRegistrationIds('DeV1CeT0kEN')
    ->setType(\Google\Client\GCM\Message\PayloadMessage::TYPE_JSON)
    ->setData($Data);

// Create GCM client
$Client = new Google\Client\GCM\Client();
$Client->getRequest()->setConnectTimeout(60);
$Client->setAuthorizationKey('aUTH0R1Z4t1oNKEy');

// ...and send the message
$Response = $Client->send($Message);
var_dump($Response);