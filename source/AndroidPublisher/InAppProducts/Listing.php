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
