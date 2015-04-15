<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\AndroidPublisher\Purchases\Products;
use alxmsl\Google\InitializationInterface;

/**
 * Class of in-app product purchase resource
 * @author alxmsl
 */
final class Resource implements InitializationInterface {
    /**
     * Consumption state constants
     */
    const STATE_YET_CONSUMED = 0,
          STATE_CONSUMED     = 1;

    /**
     * Order state constants
     */
    const ORDER_PURCHASED = 0,
          ORDER_CANCELLED = 1;

    /**
     * @var int purchase consumption state
     */
    private $consumptionState = 0;

    /**
     * @var string developer-specified string that contains supplemental information about an order
     */
    private $developerPayload = '';

    /**
     * @var string represents an in-app purchase object in the android publisher service
     */
    private $kind = '';

    /**
     * @var int purchase state of the order
     */
    private $purchaseState = 0;

    /**
     * @var int time the product was purchased, milliseconds
     */
    private $purchaseTimeMillis = 0;

    /**
     * @return int purchase consumption state
     */
    public function getConsumptionState() {
        return $this->consumptionState;
    }

    /**
     * @return string developer-specified string that contains supplemental information about an order
     */
    public function getDeveloperPayload() {
        return $this->developerPayload;
    }

    /**
     * @return string represents an in-app purchase object in the android publisher service
     */
    public function getKind() {
        return $this->kind;
    }

    /**
     * @return int purchase state of the order
     */
    public function getPurchaseState() {
        return $this->purchaseState;
    }

    /**
     * @return int time the product was purchased, milliseconds
     */
    public function getPurchaseTimeMillis() {
        return $this->purchaseTimeMillis;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByString($string) {
        $Object   = json_decode($string);
        $Resource = new Resource();

        $Resource->consumptionState   = (int) $Object->consumptionState;
        $Resource->developerPayload   = (string) $Object->developerPayload;
        $Resource->kind               = (string) $Object->kind;
        $Resource->purchaseState      = (int) $Object->purchaseState;
        $Resource->purchaseTimeMillis = (int) $Object->purchaseTimeMillis;
        return $Resource;
    }
}
