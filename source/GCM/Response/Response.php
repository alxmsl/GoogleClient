<?php

namespace Google\Client\GCM\Response;

use Google\Client\GCM\Message\PayloadMessage;
use Google\Client\InitializationInterface;

/**
 * 
 * @author alxmsl
 * @date 5/28/13
 */ 
final class Response implements InitializationInterface {
    /**
     * @var int content type identifier for payload data serialization
     */
    public static $type = PayloadMessage::TYPE_PLAIN;

    private $multicastId = '';

    private $successCount = 0;

    private $failureCount = 0;

    private $canonicalIdsCount = 0;

    /**
     * @var Status[]
     */
    private $results = array();

    /**
     * @param int $canonicalIdsCount
     * @return Response
     */
    public function setCanonicalIdsCount($canonicalIdsCount)
    {
        $this->canonicalIdsCount = $canonicalIdsCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getCanonicalIdsCount()
    {
        return $this->canonicalIdsCount;
    }

    /**
     * @param int $failureCount
     * @return Response
     */
    public function setFailureCount($failureCount)
    {
        $this->failureCount = $failureCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getFailureCount()
    {
        return $this->failureCount;
    }

    /**
     * @param string $multicastId
     * @return Response
     */
    public function setMulticastId($multicastId)
    {
        $this->multicastId = $multicastId;
        return $this;
    }

    /**
     * @return string
     */
    public function getMulticastId()
    {
        return $this->multicastId;
    }

    /**
     * @param int $successCount
     * @return Response
     */
    public function setSuccessCount($successCount)
    {
        $this->successCount = $successCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getSuccessCount()
    {
        return $this->successCount;
    }

    /**
     * @return \Google\Client\GCM\Response\Status[]
     */
    public function getResults() {
        return $this->results;
    }

    /**
     * Initialization method
     * @param string $string data for object initialization
     * @return InitializationInterface initialized object
     */
    public static function initializeByString($string) {
        switch (self::$type) {
            case PayloadMessage::TYPE_PLAIN:

                //todo: make result for plain text response

                break;
            case PayloadMessage::TYPE_JSON:
                $Data = json_decode($string);
                $Response = new self();
                $Response->canonicalIdsCount = (int) $Data->canonical_ids;
                $Response->failureCount = (int) $Data->failure;
                $Response->multicastId = (string) $Data->multicast_id;
                $Response->successCount = (int) $Data->success;

                foreach ($Data->results as $Result) {
                    $Status = new Status();
                    if (isset($Result->message_id)) {
                        $Status->setMessageId($Result->message_id);
                    }
                    if (isset($Result->registration_id)) {
                        $Status->setRegistrationId($Result->registration_id);
                    }
                    if (isset($Result->error)) {
                        $Status->setError($Result->error);
                    }
                    $Response->results[] = $Status;
                }
                return $Response;
        }
    }
}
