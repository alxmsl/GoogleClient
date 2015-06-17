<?php
/*
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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
