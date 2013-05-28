<?php

namespace Google\Client\GCM\Response;

/**
 * 
 * @author alxmsl
 * @date 5/28/13
 */ 
final class Response {

    private $multicastId = '';

    private $successCount = 0;

    private $failureCount = 0;

    private $canonicalIdsCount = 0;

    /**
     * @var Status[]
     */
    private $results = array();

}
