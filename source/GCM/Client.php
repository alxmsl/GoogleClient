<?php

namespace Google\Client\GCM;

use Google\Client\GCM\Message\PayloadMessage;
use Network\Http\HttpClientErrorCodeException;
use Network\Http\HttpServerErrorCodeException;
use \Network\Http\Request;

/**
 * GCM sender client class
 * @author alxmsl
 * @date 5/26/13
 */ 
final class Client {
    /**
     * Supported content types
     */
    const   CONTENT_TYPE_JSON       = 'application/json',
            CONTENT_TYPE_PLAIN_TEXT = 'application/x-www-form-urlencoded; charset=UTF-8';

    /**
     * GCM sender service endpoint
     */
    const ENDPOINT_SEND = 'https://android.googleapis.com/gcm/send';

    /**
     * @var string authorization key
     */
    private $authorizationKey = '';

    /**
     * @var null|Request HTTP request instance
     */
    private $Request = null;

    /**
     * Authorization key setter
     * @param string $authorizationKey authorization key
     * @return Client self
     */
    public function setAuthorizationKey($authorizationKey) {
        $this->authorizationKey = (string) $authorizationKey;
        $this->getRequest()->addHeader('Authorization', 'key=' . $this->getAuthorizationKey());
        return $this;
    }

    /**
     * Authorization key getter
     * @return string authorization key
     */
    public function getAuthorizationKey() {
        return $this->authorizationKey;
    }

    /**
     * GCM service request instance getter
     * @return Request GCM service request instance
     */
    public function getRequest() {
        if (is_null($this->Request)) {
            $this->Request = new Request();
            $this->Request->setTransport(Request::TRANSPORT_CURL);
            $this->Request->setUrl(self::ENDPOINT_SEND);
        }
        return $this->Request;
    }

    /**
     * Send GCM message method
     * @param PayloadMessage $Message GCM message instance
     * @throws GCMFormatException when request or response format was incorrect
     * @throws GCMUnauthorizedException when was incorrect authorization key
     */
    public function send(PayloadMessage $Message) {
        switch ($Message->getType()) {
            case PayloadMessage::TYPE_PLAIN:
                $this->getRequest()->setContentTypeCode(Request::CONTENT_TYPE_UNDEFINED);
                $this->getRequest()->addHeader('Content-Type', self::CONTENT_TYPE_PLAIN_TEXT);
                break;
            case PayloadMessage::TYPE_JSON:
                $this->getRequest()->setContentTypeCode(Request::CONTENT_TYPE_JSON);
                $this->getRequest()->addHeader('Content-Type', self::CONTENT_TYPE_JSON);
                break;
            default:
                throw new GCMFormatException('unsupported message format code \'' . $Message->getType() . '\'');
        }
        $this->getRequest()->setPostData($Message->export());
        try {
            $Result = $this->getRequest()->send();

            //todo: define response instance

            var_dump($Result);
        } catch (HttpClientErrorCodeException $Ex) {
            switch ($Ex->getCode()) {
                case '400':
                    throw new GCMFormatException('invalid JSON request with message \'' . $Ex->getMessage() . '\'');
                case '401':
                    throw new GCMUnauthorizedException('invalid authorization key \'' . $this->getAuthorizationKey() . '\'');
            }
        } catch (HttpServerErrorCodeException $Ex) {

        }
    }
}

/**
 * Base GCM sender exception
 */
class GCMException extends \Exception {}

/**
 * Except when GCM request or response format is incorrect
 */
final class GCMFormatException extends GCMException {}

/**
 * Except when GCM request has incorrect authorization key
 */
final class GCMUnauthorizedException extends GCMException {}