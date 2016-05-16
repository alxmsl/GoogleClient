<?php

namespace alxmsl\Test\Google\AndroidPublisher\Purchases\Subscriptions;

use alxmsl\Google\AndroidPublisher\Purchases\Subscriptions\SubscriptionsClient;
use PHPUnit_Framework_TestCase;

/**
 * Subscription client test
 * @author mkrasilnikov
 */
class SubscriptionsClientTest extends PHPUnit_Framework_TestCase {

    public function testRevoke() {
        $Client = new SubscriptionsClient();
        $this->assertTrue($Client->revoke('productId', 'token'));
    }
}
