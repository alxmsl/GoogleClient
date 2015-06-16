<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
