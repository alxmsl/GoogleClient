<?php

namespace Google\Client\GCM\Message;

/**
 * Class for send-to-sync GCM message
 * @author alxmsl
 * @date 5/27/13
 */ 
final class SyncMessage extends PayloadMessage {
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
        return parent::export() + array(
            'collapse_key' => $this->getCollapseKey(),
        );
    }
}
