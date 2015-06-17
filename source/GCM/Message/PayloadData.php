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

use alxmsl\Google\GCM\Exportable;

/**
 * Abstract payload data
 * @author alxmsl
 * @date 5/27/13
 */ 
abstract class PayloadData implements Exportable {
    /**
     * @var int content type identifier for payload data serialization
     */
    private $type = PayloadMessage::TYPE_PLAIN;

    /**
     * Content type identifier setter
     * @param int $type content type identifier
     * @return PayloadData self
     */
    public function setType($type) {
        $this->type = (int) $type;
        return $this;
    }

    /**
     * Content type identifier getter
     * @return int content type identifier
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Abstract getter for payload data
     * @return array payload data
     */
    abstract protected function getDataFields();

    /**
     * Method for export instance data
     * @return array exported data
     */
    public function export() {
        $data = array();
        switch ($this->getType()) {
            case PayloadMessage::TYPE_PLAIN:
                foreach ($this->getDataFields() as $key => $value) {
                    $data['data.' . $key] = (string) $value;
                }
                break;
            case PayloadMessage::TYPE_JSON:
                $data['data'] = $this->getDataFields();
        }
        return $data;
    }
}
