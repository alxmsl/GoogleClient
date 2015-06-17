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
