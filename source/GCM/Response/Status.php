<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\GCM\Response;

/**
 * Class for message delivery status
 * @author alxmsl
 * @date 5/28/13
 */ 
final class Status {
    /**
     * Error constants
     */
    const STATUS_UNAVAILABLE           = 'Unavailable',
          STATUS_NOT_REGISTERED        = 'NotRegistered',
          STATUS_MISSING_REGISTRATION  = 'MissingRegistration',
          STATUS_INVALID_REGISTRATION  = 'InvalidRegistration',
          STATUS_MISMATCH_SENDER_ID    = 'MismatchSenderId',
          STATUS_MESSAGE_TOO_BIG       = 'MessageTooBig',
          STATUS_INVALID_DATA_KEY      = 'InvalidDataKey',
          STATUS_INVALID_TTL           = 'InvalidTtl',
          STATUS_INTERNAL_SERVER_ERROR = 'InternalServerError';

    /**
     * @var string message identifier
     */
    private $messageId = '';

    /**
     * @var string canonical device identifier
     */
    private $canonicalId = '';

    /**
     * @var string error code
     */
    private $error = '';

    /**
     * Error code setter
     * @param string $error error code
     * @return Status self
     */
    public function setError($error) {
        $this->error = (string) $error;
        return $this;
    }

    /**
     * Error code getter
     * @return string error code
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Message identifier setter
     * @param string $messageId message identifier
     * @return Status self
     */
    public function setMessageId($messageId) {
        $this->messageId = (string) $messageId;
        return $this;
    }

    /**
     * Message identifier getter
     * @return string message identifier
     */
    public function getMessageId() {
        return $this->messageId;
    }

    /**
     * Canonical identifier setter
     * @param string $registrationId canonical identifier
     * @return Status self
     */
    public function setCanonicalId($registrationId) {
        $this->canonicalId = (string) $registrationId;
        return $this;
    }

    /**
     * Canonical identifier getter
     * @return string canonical identifier
     */
    public function getCanonicalId() {
        return $this->canonicalId;
    }

    /**
     * Check status for new device registration identifier
     * @return bool true when status has new device registration identifier
     */
    public function hasCanonicalId() {
        return !empty($this->canonicalId);
    }

    /**
     * Check status for need to remove device registration identifier
     * @return bool true when need to remove device registration identifier
     */
    public function mustRemove() {
        return $this->getError() == self::STATUS_NOT_REGISTERED;
    }

    /**
     * Check status for can to retry message sending
     * @return bool true when can to retry message sending
     */
    public function canRetry() {
        return $this->getError() == self::STATUS_UNAVAILABLE
            || $this->getError() == self::STATUS_INTERNAL_SERVER_ERROR;
    }
}
