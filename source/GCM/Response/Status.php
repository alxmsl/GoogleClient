<?php

namespace Google\Client\GCM\Response;

/**
 * 
 * @author alxmsl
 * @date 5/28/13
 */ 
final class Status {

    const   STATUS_UNAVAILABLE          = 'Unavailable',
            STATUS_NOT_REGISTERED       = 'NotRegistered',
            STATUS_MISSING_REGISTRATION = 'MissingRegistration',
            STATUS_INVALID_REGISTRATION = 'InvalidRegistration',
            STATUS_MISMATCH_SENDER_ID   = 'MismatchSenderId',
            STATUS_MESSAGE_TOO_BIG      = 'MessageTooBig',
            STATUS_INVALID_DATA_KEY     = 'InvalidDataKey',
            STATUS_INVALID_TTL          = 'InvalidTtl',
            STATUS_INTERNAL_SERVER_ERROR = 'InternalServerError';

    private $messageId = '';

    private $registrationId = '';

    private $error = '';

    /**
     * @param string $error
     * @return Status
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $messageId
     * @return Status
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param string $registrationId
     * @return Status
     */
    public function setRegistrationId($registrationId)
    {
        $this->registrationId = $registrationId;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegistrationId()
    {
        return $this->registrationId;
    }
}
