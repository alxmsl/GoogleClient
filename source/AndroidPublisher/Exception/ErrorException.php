<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\AndroidPublisher\Exception;

use alxmsl\Google\InitializationInterface;
use Exception;
use stdClass;

/**
 * Class for AndroidPublisher API errors
 * @author alxmsl
 */
class ErrorException extends Exception implements InitializationInterface {
    /**
     * @var stdClass[] error objects
     */
    private $errors = [];

    /**
     * @return stdClass[] error objects
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * @inheritdoc
     * @return ErrorException error instance
     */
    public static function initializeByString($string) {
        $Object = json_decode($string);
        if (!is_null($Object)) {
            $ErrorException = new static($Object->error->message, $Object->error->code);
            $ErrorException->errors = (array) $Object->error->errors;
        } else {
            $ErrorException = new static($string);
        }
        return $ErrorException;
    }
}
