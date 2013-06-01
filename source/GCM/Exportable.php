<?php

namespace Google\Client\GCM;

/**
 * Interface for exportable objects
 * @author alxmsl
 * @date 5/28/13
 */
interface Exportable {
    /**
     * Method for export instance data
     * @return array exported data
     */
    public function export();
}
