<?php

namespace Google\Client\OAuth2\Response;

/**
 * Class for error response
 * @author alxmsl
 * @date 2/5/13
 */ 
final class ErrorResponse {
    /**
     * Error string constants
     */
    const   STRING_INVALID_GRANT    = 'invalid_grant',
            STRING_INVALID_CLIENT   = 'invalid_client';

    /**
     * @var string google error code
     */
    private $error = '';

    /**
     * Setter for error code
     * @param string $error error code
     * @return ErrorResponse self
     */
    private function setError($error) {
        $this->error = (string) $error;
        return $this;
    }

    /**
     * Getter for invalid grant error
     * @return bool if error is invalid grant
     */
    public function isInvalidGrant() {
        return $this->error == self::STRING_INVALID_GRANT;
    }

    /**
     * Getter for invalid client error
     * @return bool if error is invalid client
     */
    public function isInvalidClient() {
        return $this->error == self::STRING_INVALID_CLIENT;
    }

    /**
     * Lock for object creation
     */
    private function __construct() {}

    /**
     * Method for object initialization by the string
     * @param string $string response string
     * @return ErrorResponse error object
     */
    public static function initializeByString($string) {
        $object = json_decode($string);
        $Response = new self();
        $Response->setError($object->error);
        return $Response;
    }
}
