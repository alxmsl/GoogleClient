<?php

namespace Google\Client\GCM\Message;

/**
 * 
 * @author alxmsl
 * @date 5/27/13
 */ 
final class SyncMessage extends PayloadMessage {

    private $collapseKey = '';

    /**
     * @param string $collapseKey
     * @return SyncMessage
     */
    public function setCollapseKey($collapseKey) {
        $this->collapseKey = (string) $collapseKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getCollapseKey() {
        return $this->collapseKey;
    }

    public function export() {
        return parent::export() + array(
            'collapse_key' => $this->getCollapseKey(),
        );
    }
}
