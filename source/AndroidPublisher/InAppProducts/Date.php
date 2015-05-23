<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
