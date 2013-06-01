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
}
