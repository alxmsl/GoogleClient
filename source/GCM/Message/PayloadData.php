<?php

namespace Google\Client\GCM\Message;
use Google\Client\GCM\Exportable;

/**
 * 
 * @author alxmsl
 * @date 5/27/13
 */ 
abstract class PayloadData implements Exportable {
    private $type = PayloadMessage::TYPE_PLAIN;

    /**
     * @param int $type
     * @return PayloadData
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    abstract protected function getDataFields();

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
