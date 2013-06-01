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
$Message->setRegistrationIds('APA91bHQHQQWD7a89wl2WZHYwBHvVl61zMiI5HMx3daZ9_S_5jK30U3q6BpAirUM7oa8bRQtT3yYF_BJt_aFAlt_CPbLoxQppE7sIiGJbWz9TrX0azVFLyO5QIW5VDkSLy63o6JQRn2-uiI3BD8Tx0GfwKYup6vOpg')
    ->setType(\Google\Client\GCM\Message\PayloadMessage::TYPE_JSON)
    ->setData($Data);

// Create GCM client
$Client = new Google\Client\GCM\Client();
$Client->getRequest()->setConnectTimeout(60);
$Client->setAuthorizationKey('AIzaSyCudpfOv6m2hNysZAWhw5T0UmW7n_7liNY');

// ...and send the message
$Response = $Client->send($Message);
var_dump($Response);