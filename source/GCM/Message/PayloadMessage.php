<?php

namespace Google\Client\GCM\Message;
use Google\Client\GCM\Exportable;
use Google\Client\GCM\GCMMessageFormatException;

/**
 * 
 * @author alxmsl
 * @date 5/26/13
 */ 
class PayloadMessage implements Exportable {

    const TYPE_PLAIN = 0,
        TYPE_JSON = 1;

    const COUNT_REGISTRATION_IDS = 1000;

    private $registrationIds = null;

    private $type = self::TYPE_PLAIN;

    private $delayWhileIdle = false;

    private $timeToLive = 0;

    private $restrictedPackageName = '';

    private $dryRun = true;

    private $Data = null;

    /**
     * @param int $type
     * @return PayloadMessage
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
        return $this;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param int $delayWhileIdle
     * @return PayloadMessage
     */
    public function setDelayWhileIdle($delayWhileIdle) {
        $this->delayWhileIdle = (bool) $delayWhileIdle;
        return $this;
    }

    /**
     * @return int
     */
    public function needDelayWhileIdle() {
        return $this->delayWhileIdle;
    }

    /**
     * @param boolean $dryRun
     * @return PayloadMessage
     */
    public function setDryRun($dryRun) {
        $this->dryRun = (bool) $dryRun;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDryRun() {
        return $this->dryRun;
    }

    /**
     * @param string $restrictedPackageName
     * @return PayloadMessage
     */
    public function setRestrictedPackageName($restrictedPackageName) {
        $this->restrictedPackageName = (string) $restrictedPackageName;
        return $this;
    }

    /**
     * @return string
     */
    public function getRestrictedPackageName() {
        return $this->restrictedPackageName;
    }

    public function hasRestrictedPackageName() {
        return !empty($this->restrictedPackageName);
    }

    /**
     * @param null|mixed $registrationIds
     * @return PayloadMessage
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
     * @return null|mixed
     */
    public function getRegistrationIds() {
        return $this->registrationIds;
    }

    /**
     * @param int $timeToLive
     * @return PayloadMessage
     */
    public function setTimeToLive($timeToLive) {
        $this->timeToLive = (int) $timeToLive;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeToLive() {
        return $this->timeToLive;
    }

    /**
     * @param null $Data
     * @return PayloadMessage
     */
    public function setData(PayloadData $Data) {
        $this->Data = $Data;
        $this->Data
        return $this;
    }

    /**
     * @return null|Exportable
     */
    public function getData() {
        return $this->Data;
    }

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

class GCMMessageException extends \Exception {}
final class GCMRegistrationIdsIncorrectForMessageType extends GCMMessageException {}