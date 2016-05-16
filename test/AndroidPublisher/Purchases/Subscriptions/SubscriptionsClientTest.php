<?php

namespace alxmsl\Test\Google\AndroidPublisher\Purchases\Subscriptions;

use alxmsl\Google\AndroidPublisher\Purchases\Subscriptions\SubscriptionsClient;
use PHPUnit_Framework_TestCase;
use UnexpectedValueException;

/**
 * Subscription client test
 * @author mkrasilnikov
 */
class SubscriptionsClientTest extends PHPUnit_Framework_TestCase {

    public function testRevokeSubscription() {
        $this->setExpectedException(UnexpectedValueException::class);
        $Client = new SubscriptionsClient();
        $this->assertTrue($Client->revokeSubscription('productId', 'token'));
    }
}
