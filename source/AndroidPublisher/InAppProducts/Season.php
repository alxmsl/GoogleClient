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
 * Class for season for a seasonal subscription
 * @author alxmsl
 */
final class Season implements ObjectInitializedInterface {
    /**
     * @var null|Date inclusive end date of the recurrence period
     */
    private $end = null;

    /**
     * @var null|Date inclusive start date of the recurrence period
     */
    private $start = null;

    /**
     * @return Date|null inclusive end date of the recurrence period
     */
    public function getEnd() {
        return $this->end;
    }

    /**
     * @return Date|null inclusive start date of the recurrence period
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Instance        = new self();
        $Instance->end   = Date::initializeByObject($Object->end);
        $Instance->start = Date::initializeByObject($Object->start);
        return $Instance;
    }
}
