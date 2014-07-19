<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\OAuth2\Response;
use alxmsl\Google\InitializationInterface;

/**
 * Class for error response
 * @author alxmsl
 * @date 2/5/13
 */ 
final class Error implements InitializationInterface {
    /**
     * Error string constants
     */
    const STRING_INVALID_GRANT  = 'invalid_grant',
          STRING_INVALID_CLIENT = 'invalid_client';

    /**
     * @var string google error code
     */
    private $error = '';

    /**
     * Setter for error code
     * @param string $error error code
     * @return Error self
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

    private function __construct() {}

    /**
     * Method for object initialization by the string
     * @param string $string response string
     * @return Error error object
     */
    public static function initializeByString($string) {
        $object = json_decode($string);
        $Response = new self();
        $Response->setError($object->error);
        return $Response;
    }
}
