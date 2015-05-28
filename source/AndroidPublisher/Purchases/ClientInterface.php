<?php

namespace alxmsl\Google\AndroidPublisher\Purchases;

use alxmsl\Google\AndroidPublisher\Exception\ErrorException;
use RuntimeException;

/**
 * Google Purchases API interface
 * @author alxmsl
 */
interface ClientInterface {
    /**
     * Check user product purchases
     * @param string $productId product identifier
     * @param string $token purchase product token
     * @return Resource product purchase resource instance
     * @throws ErrorException when API error acquired
     * @throws RuntimeException when type code for client is not supported now
     */
    public function get($productId, $token);
}
