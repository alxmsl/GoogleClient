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

namespace alxmsl\Google\GCM\Message;

/**
 * Class for send-to-sync GCM message
 * @author alxmsl
 * @date 5/27/13
 */ 
class SyncMessage extends PayloadMessage {
    /**
     * @var string messages collapse key
     */
    private $collapseKey = '';

    /**
     * Collapse key setter
     * @param string $collapseKey collapse key
     * @return SyncMessage self
     */
    public function setCollapseKey($collapseKey) {
        $this->collapseKey = (string) $collapseKey;
        return $this;
    }

    /**
     * Collapse key getter
     * @return string collapse key
     */
    public function getCollapseKey() {
        return $this->collapseKey;
    }

    /**
     * Method for export instance data
     * @return array exported data
     */
    public function export() {
        return parent::export() + [
            'collapse_key' => $this->getCollapseKey(),
        ];
    }
}
