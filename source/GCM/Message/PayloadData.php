<?php

namespace Google\Client\GCM\Message;

use Google\Client\GCM\Exportable;

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
