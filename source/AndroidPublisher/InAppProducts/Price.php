<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\AndroidPublisher\InAppProducts;

use alxmsl\Google\ObjectInitializedInterface;
use stdClass;

/**
 * Buyer region price
 * @author alxmsl
 */
final class Price implements ObjectInitializedInterface {
    /**
     * @var string currency code, as defined by ISO 4217
     */
    private $currency = '';

    /**
     * @var string price in millionths of the currency base unit represented as a string
     */
    private $priceMicros = '';

    /**
     * @return string currency code, as defined by ISO 4217
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @return string price in millionths of the currency base unit represented as a string
     */
    public function getPriceMicros() {
        return $this->priceMicros;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Instance              = new self();
        $Instance->currency    = (string) $Object->currency;
        $Instance->priceMicros = (string) $Object->priceMicros;
        return $Instance;
    }
}
