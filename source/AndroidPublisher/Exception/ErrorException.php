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
        if (!is_null($Object) && isset($Object->error)) {
            $ErrorException = new static($Object->error->message, $Object->error->code);
            if (isset($Object->error->errors)) {
                $ErrorException->errors = (array) $Object->error->errors;
            }
        } else {
            $ErrorException = new static($string);
        }
        return $ErrorException;
    }
}
