<?php
/*
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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
          ORDER_CANCELLED = 1,
          ORDER_UNKNOWN   = -1;

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
    private $purchaseState = self::ORDER_UNKNOWN;

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
     * @return bool is purchase consumed
     */
    public function isConsumed() {
        return $this->getConsumptionState() == self::STATE_CONSUMED;
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
     * @return bool is product cancelled
     */
    public function isCancelled() {
        return $this->getPurchaseState() == self::ORDER_CANCELLED;
    }

    /**
     * @return bool is product purchased
     */
    public function isPurchased() {
        return $this->getPurchaseState() == self::ORDER_PURCHASED;
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

    /**
     * @inheritdoc
     */
    public function __toString() {
        $consumptionState = 'unknown';
        switch ($this->getConsumptionState()) {
            case self::STATE_CONSUMED:
                $consumptionState = 'consumed';
                break;
            case self::STATE_YET_CONSUMED:
                $consumptionState = 'yet to be consumed';
                break;
        }
        $purchaseState = 'unknown';
        switch ($this->getPurchaseState()) {
            case self::ORDER_CANCELLED:
                $purchaseState = 'cancelled';
                break;
            case self::ORDER_PURCHASED:
                $purchaseState = 'purchase';
                break;
        }

        $format = <<<'EOD'
    consumptionState:   %s
    developerPayload:   %s
    kind:               %s
    purchaseState:      %s
    purchaseTimeMillis: %s
EOD;
        return sprintf($format
            , $consumptionState
            , $this->getDeveloperPayload()
            , $this->getKind()
            , $purchaseState
            , date('Y-m-d H:i:s', $this->getPurchaseTimeMillis() / 1000));
    }
}
