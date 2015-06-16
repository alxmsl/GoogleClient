<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\GCM\Response;
use alxmsl\Google\GCM\Exception\GCMFormatException;
use alxmsl\Google\GCM\Message\PayloadMessage;
use alxmsl\Google\InitializationInterface;

/**
 * GCM message sending response class
 * @author alxmsl
 * @date 5/28/13
 */ 
final class Response implements InitializationInterface {
    /**
     * @var int content type identifier for payload data serialization
     */
    public static $type = PayloadMessage::TYPE_PLAIN;

    /**
     * @var string multicast identifier
     */
    private $multicastId = '';

    /**
     * @var int success messages count
     */
    private $successCount = 0;

    /**
     * @var int failure messages count
     */
    private $failureCount = 0;

    /**
     * @var int count of found devices with canonical identifiers
     */
    private $canonicalIdsCount = 0;

    /**
     * @var Status[] result statuses
     */
    private $results = [];

    /**
     * Count of canonical identifiers setter
     * @param int $canonicalIdsCount count of canonical identifiers
     * @return Response self
     */
    public function setCanonicalIdsCount($canonicalIdsCount) {
        $this->canonicalIdsCount = (int) $canonicalIdsCount;
        return $this;
    }

    /**
     * Getter for count of canonical identifiers
     * @return int count of canonical identifiers
     */
    public function getCanonicalIdsCount() {
        return $this->canonicalIdsCount;
    }

    /**
     * Count of failure messages setter
     * @param int $failureCount failure messages count
     * @return Response self
     */
    public function setFailureCount($failureCount) {
        $this->failureCount = (int) $failureCount;
        return $this;
    }

    /**
     * Count of failure messages getter
     * @return int failure messages getter
     */
    public function getFailureCount() {
        return $this->failureCount;
    }

    /**
     * Multicast identifier setter
     * @param string $multicastId multicast identifier
     * @return Response self
     */
    public function setMulticastId($multicastId) {
        $this->multicastId = (string) $multicastId;
        return $this;
    }

    /**
     * Multicast identifier getter
     * @return string multicast identifier
     */
    public function getMulticastId() {
        return $this->multicastId;
    }

    /**
     * Count of success messages setter
     * @param int $successCount success messages count
     * @return Response self
     */
    public function setSuccessCount($successCount) {
        $this->successCount = (int) $successCount;
        return $this;
    }

    /**
     * Count of success messages getter
     * @return int count of success messages
     */
    public function getSuccessCount() {
        return $this->successCount;
    }

    /**
     * Result statuses getter
     * @return Status[] result statuses
     */
    public function getResults() {
        return $this->results;
    }

    /**
     * Initialization method
     * @param string $string data for object initialization
     * @return $this initialized object
     * @throws GCMFormatException for unknown response format
     */
    public static function initializeByString($string) {
        switch (self::$type) {
            case PayloadMessage::TYPE_PLAIN:
                return self::createPlainResponse($string);
            case PayloadMessage::TYPE_JSON:
                return self::createJsonResponse($string);
            default:
                throw new GCMFormatException('unsupported response format code \'' . self::$type . '\'');
        }
    }

    /**
     * Create response object by plain text data
     * @param string $string plain text data
     * @return Response self
     * @throws GCMFormatException when plain text data format was not supported
     */
    private static function createPlainResponse($string) {
        $parts = explode("\n", $string);
        $firstLine = explode('=', $parts[0]);

        $Response = new self();
        $Status = new Status();
        if (isset($parts[1])) {
            $secondLine = explode('=', $parts[1]);
            if ($secondLine[0] == 'registration_id') {
                $Response->canonicalIdsCount = 1;
                $Status->setCanonicalId($secondLine[1]);
            } else {
                throw new GCMFormatException('unknown second line response field \'' . $firstLine[0] . '\'');
            }
        }
        switch ($firstLine[0]) {
            case 'id':
                $Response->successCount = 1;
                $Response->failureCount = 0;
                $Status->setMessageId($firstLine[1]);
                break;
            case 'Error':
                $Response->successCount = 0;
                $Response->failureCount = 1;
                $Status->setError($firstLine[1]);
                break;
            default:
                throw new GCMFormatException('unknown first line response field \'' . $firstLine[0] . '\'');
        }
        $Response->results[] = $Status;
        return $Response;
    }

    /**
     * Create response object by JSON data
     * @param string $string JSON response data
     * @return Response self
     */
    private static function createJsonResponse($string) {
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
                $Status->setCanonicalId($Result->registration_id);
            }
            if (isset($Result->error)) {
                $Status->setError($Result->error);
            }
            $Response->results[] = $Status;
        }
        return $Response;
    }
}
