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
 * Localized in-app purchase data
 * @author alxmsl
 */
final class Listing implements ObjectInitializedInterface {
    /**
     * @var string description
     */
    private $description = '';

    /**
     * @var string title
     */
    private $title = '';

    /**
     * @return string description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return string title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Instance              = new self();
        $Instance->description = (string) $Object->description;
        $Instance->title       = (string) $Object->title;
        return $Instance;
    }
}
