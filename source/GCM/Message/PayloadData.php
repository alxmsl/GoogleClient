<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
