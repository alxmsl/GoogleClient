<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\GCM\Message;
use alxmsl\Google\GCM\Exception\GCMRegistrationIdsIncorrectForMessageType;
use alxmsl\Google\GCM\Exportable;

/**
 * Class for payload GCM message
 * @author alxmsl
 * @date 5/26/13
 */ 
class PayloadMessage implements Exportable {
    /**
     * GCM messages content types constants
     */
    const TYPE_PLAIN = 0,
          TYPE_JSON  = 1;

    /**
     * Maximum registration ids for multicast messages
     */
    const COUNT_REGISTRATION_IDS = 1000;

    /**
     * @var null|array|string registration id or ids
     */
    private $registrationIds = null;

    /**
     * @var int content type code
     */
    private $type = self::TYPE_PLAIN;

    /**
     * @var bool do not send message when device is idle
     */
    private $delayWhileIdle = false;

    /**
     * @var int TTL for the message, seconds
     */
    private $timeToLive = 0;

    /**
     * @var string package name for delivery registration ids limitation
     */
    private $restrictedPackageName = '';

    /**
     * @var bool need dry run sending for the message
     */
    private $dryRun = false;

    /**
     * @var null|PayloadData message payload data
     */
    private $Data = null;

    /**
     * Content type code setter
     * @param int $type content type code
     * @return PayloadMessage self
     * @throws GCMRegistrationIdsIncorrectForMessageType when registration ids array was empty
     */
    public function setType($type) {
        $registrationIds = $this->getRegistrationIds();
        $this->type = $type;
        switch ($this->type) {
            case self::TYPE_PLAIN:
                if (is_array($registrationIds)) {
                    if (count($registrationIds) <= 1) {
                        $this->registrationIds = reset($registrationIds);
                    } else {
                        throw new GCMRegistrationIdsIncorrectForMessageType('cannot use multiple registration ids for plain text message');
                    }
                }
                break;
            case self::TYPE_JSON:
                $this->registrationIds = (array) $registrationIds;
                break;
        }
        if (!is_null($this->getData())) {
            $this->getData()->setType($this->getType());
        }
        return $this;
    }

    /**
     * Content type code getter
     * @return int content type code
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set needing delay while idle
     * @param bool $delayWhileIdle need delay while idle
     * @return PayloadMessage self
     */
    public function setDelayWhileIdle($delayWhileIdle) {
        $this->delayWhileIdle = (bool) $delayWhileIdle;
        return $this;
    }

    /**
     * Need delay while idle or not
     * @return bool need delay while idle or not
     */
    public function needDelayWhileIdle() {
        return $this->delayWhileIdle;
    }

    /**
     * Dry run message delivery setter
     * @param boolean $dryRun need dry run message delivery or not
     * @return PayloadMessage self
     */
    public function setDryRun($dryRun) {
        $this->dryRun = (bool) $dryRun;
        return $this;
    }

    /**
     * Dry run message delivery
     * @return boolean dry run or not
     */
    public function isDryRun() {
        return $this->dryRun;
    }

    /**
     * Package name setter
     * @param string $restrictedPackageName package name
     * @return PayloadMessage self
     */
    public function setRestrictedPackageName($restrictedPackageName) {
        $this->restrictedPackageName = (string) $restrictedPackageName;
        return $this;
    }

    /**
     * Package name getter
     * @return string package name
     */
    public function getRestrictedPackageName() {
        return $this->restrictedPackageName;
    }

    /**
     * Has set package name or not
     * @return bool has package name or not
     */
    public function hasRestrictedPackageName() {
        return !empty($this->restrictedPackageName);
    }

    /**
     * Registration id or ids setter
     * @param null|array|string $registrationIds registration id or ids
     * @return PayloadMessage self
     */
    public function setRegistrationIds($registrationIds) {
        switch ($this->getType()) {
            case self::TYPE_JSON:
                $this->registrationIds = (array) $registrationIds;
                break;
            case self::TYPE_PLAIN:
                $this->registrationIds = (string) $registrationIds;
                break;
        }
        return $this;
    }

    /**
     * Registration id or ids getter
     * @return null|array|string registration id or ids for message delivery
     */
    public function getRegistrationIds() {
        return $this->registrationIds;
    }

    /**
     * TTL setter
     * @param int $timeToLive ttl value, seconds
     * @return PayloadMessage self
     */
    public function setTimeToLive($timeToLive) {
        $this->timeToLive = (int) $timeToLive;
        return $this;
    }

    /**
     * TTL getter
     * @return int ttl value
     */
    public function getTimeToLive() {
        return $this->timeToLive;
    }

    /**
     * Payload data setter
     * @param PayloadData $Data payload data instance
     * @return PayloadMessage self
     */
    public function setData(PayloadData $Data) {
        $this->Data = $Data;
        $this->Data->setType($this->getType());
        return $this;
    }

    /**
     * Payload data getter
     * @return null|PayloadData payload data
     */
    public function getData() {
        return $this->Data;
    }

    /**
     * Method for export instance data
     * @return array exported data
     */
    public function export() {
        $data = array();
        if ($this->getRegistrationIds()) {
            switch ($this->getType()) {
                case self::TYPE_JSON:
                    $data['registration_ids'] = (array) $this->getRegistrationIds();
                    break;
                case self::TYPE_PLAIN:
                    $data['registration_id'] = $this->getRegistrationIds();
                    break;
            }
        }
        $data['delay_while_idle'] = $this->needDelayWhileIdle();
        $data['dry_run'] = $this->isDryRun();
        if ($this->getTimeToLive() > 0) {
            $data['time_to_live'] = $this->getTimeToLive();
        }
        if ($this->hasRestrictedPackageName()) {
            $data['restricted_package_name'] = $this->getRestrictedPackageName();
        }
        if (!is_null($this->getData())) {
            $data += $this->getData()->export();
        }
        return $data;
    }
}
