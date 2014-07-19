<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\Purchases\Response;
use alxmsl\Google\InitializationInterface;

/**
 * User subscription resource
 * @author alxmsl
 * @date 2/9/13
 */ 
final class Resource implements InitializationInterface {
    /**
     * @var string static kind string
     */
    private $kind = '';

    /**
     * @var int subscription initiation timestamp, msec
     */
    private $initiationTime = 0;

    /**
     * @var int subscription valid timestamp, msec
     */
    private $validUntilTime = 0;

    /**
     * @var bool for auto renewed subscriptions
     */
    private $autoRenew = false;

    /**
     * Setter for subscription auto renewed value
     * @param bool $autoRenew auto renewed value
     * @return Resource self
     */
    private function setAutoRenew($autoRenew) {
        $this->autoRenew = (bool) $autoRenew;
        return $this;
    }

    /**
     * Getter auto renewing value
     * @return bool auto renewed value
     */
    public function isAutoRenew() {
        return $this->autoRenew;
    }

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
     * Setter for subscription initiation timestamp
     * @param int $initiationTime initiation timestamp, msec
     * @return Resource self
     */
    private function setInitiationTime($initiationTime) {
        $this->initiationTime = (int) $initiationTime;
        return $this;
    }

    /**
     * Getter for subscription initiation timestamp
     * @return int subscription initiation timestamp, msec
     */
    public function getInitiationTime() {
        return $this->initiationTime;
    }

    /**
     * Setter for subscription valid timestamp
     * @param int $validUntilTime subscription valiud timestamp, msec
     * @return Resource self
     */
    private function setValidUntilTime($validUntilTime) {
        $this->validUntilTime = (int) $validUntilTime;
        return $this;
    }

    /**
     * Getter for subscription valid timestamp
     * @return int subscription valid timestamp, msec
     */
    public function getValidUntilTime() {
        return $this->validUntilTime;
    }

    /**
     * Method for object initialization by the string
     * @param string $string resource data string
     * @return Resource resource object
     */
    public static function initializeByString($string) {
        $object = json_decode($string);
        $Resource = new Resource();
        $Resource->setKind($object->kind);
        $Resource->setInitiationTime($object->initiationTimestampMsec);
        $Resource->setValidUntilTime($object->validUntilTimestampMsec);
        $Resource->setAutoRenew($object->autoRenewing);
        return $Resource;
    }
}
