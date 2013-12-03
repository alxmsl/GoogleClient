<?php

namespace Google\Client\InAppPurchases\Response;
use Google\Client\InitializationInterface;

/**
 * InApp consumable purchase resource class
 * @author alxmsl
 * @date 12/4/13
 */ 
final class Resource implements InitializationInterface {
    /**
     * Purchase state constants
     */
    const   PURCHASE_STATE_UNKNOWN      = -1,
            PURCHASE_STATE_PURCHASED    = 0,
            PURCHASE_STATE_CANCELLED    = 1;

    /**
     * Purchase consumption state constants
     */
    const   CONSUMPTION_STATE_UNKNOWN           = -1,
            CONSUMPTION_STATE_CONSUMED          = 0,
            CONSUMPTION_STATE_TO_BE_CONSUMED    = 1;

    /**
     * @var string static kind string
     */
    private $kind = '';

    /**
     * @var int purchase time, msec
     */
    private $purchaseTime = 0;

    /**
     * @var int purchase state constant
     */
    private $purchaseState = self::PURCHASE_STATE_UNKNOWN;

    /**
     * @var int purchase consumption state constant
     */
    private $consumptionState = self::CONSUMPTION_STATE_UNKNOWN;

    /**
     * @var string developer payload data
     */
    private $developerPayload = '';

    /**
     * Instance public creation lock
     */
    private function __construct() {}

    /**
     * Setter for kind value
     * @param string $kind kind value
     * @return Resource self
     */
    private function setKind($kind) {
        $this->kind = (string) $kind;
        return $this;
    }

    /**
     * Getter for kind value
     * @return string kind value
     */
    public function getKind() {
        return $this->kind;
    }

    /**
     * Purchase consumption state setter
     * @param int $consumptionState purchase consumption state constant
     * @return Resource self instance
     */
    public function setConsumptionState($consumptionState) {
        $this->consumptionState = (int) $consumptionState;
        return $this;
    }

    /**
     * Purchase consumption state getter
     * @return int purchase consumption state constant
     */
    public function getConsumptionState() {
        return $this->consumptionState;
    }

    /**
     * Payload data setter
     * @param string $developerPayload payload data
     * @return Resource self instance
     */
    public function setDeveloperPayload($developerPayload) {
        $this->developerPayload = (string) $developerPayload;
        return $this;
    }

    /**
     * Payload data getter
     * @return string payload data
     */
    public function getDeveloperPayload() {
        return $this->developerPayload;
    }

    /**
     * Purchase state setter
     * @param int $purchaseState purchase state constant
     * @return Resource self instance
     */
    public function setPurchaseState($purchaseState) {
        $this->purchaseState = (int) $purchaseState;
        return $this;
    }

    /**
     * Purchase state getter
     * @return int purchase state constant
     */
    public function getPurchaseState() {
        return $this->purchaseState;
    }

    /**
     * Purchase time setter
     * @param int $purchaseTime purchase time, msec
     * @return Resource self instance
     */
    public function setPurchaseTime($purchaseTime) {
        $this->purchaseTime = (int) $purchaseTime;
        return $this;
    }

    /**
     * Purchase time getter
     * @return int purchase time, msec
     */
    public function getPurchaseTime() {
        return $this->purchaseTime;
    }

    /**
     * Method for object initialization by the string
     * @param string $string resource data string
     * @return Resource resource object
     */
    public static function initializeByString($string) {
        $object = json_decode($string);
        $Resource = new self();
        $Resource->setKind($object->kind);
        return $Resource;
    }
}
 