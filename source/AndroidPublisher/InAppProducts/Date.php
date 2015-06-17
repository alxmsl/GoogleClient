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

namespace alxmsl\Google\AndroidPublisher\InAppProducts;

use alxmsl\Google\ObjectInitializedInterface;
use stdClass;

/**
 * Response date class
 * @author alxmsl
 */
final class Date implements ObjectInitializedInterface {
    /**
     * @var int day of a month, value in [1, 31] range
     */
    private $day = 0;

    /**
     * @var int month of a year. e.g. 1 = JAN, 2 = FEB etc
     */
    private $month = 0;

    /**
     * @return int day of a month, value in [1, 31] range
     */
    public function getDay() {
        return $this->day;
    }

    /**
     * @return int month of a year. e.g. 1 = JAN, 2 = FEB etc
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Instance        = new self();
        $Instance->day   = (int) $Object->day;
        $Instance->month = (int) $Object->month;
        return $Instance;
    }
}
