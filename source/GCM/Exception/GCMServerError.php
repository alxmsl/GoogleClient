<?php

namespace alxmsl\Google\GCM\Exception;

/**
 * Except when something wrong on the GCM server
 * @author alxmsl
 * @date 7/19/14
 */ 
final class GCMServerError extends GCMException {
    /**
     * @var int retry timeout
     */
    private $retryAfter = 0;

    /**
     * Retry timeout getter
     * @return int retry timeout timestamp
     */
    public function getRetryAfter() {
        return $this->retryAfter;
    }

    /**
     * @param null|string $retryAfter retry after header value
     * @param string $message exception message
     * @param int $code exception error code
     */
    public function __construct($retryAfter = null, $message = '', $code = 0) {
        if (!is_null($retryAfter)) {
            $this->retryAfter = strtotime($retryAfter);
        }
        parent::__construct($message, $code);
    }
}
 