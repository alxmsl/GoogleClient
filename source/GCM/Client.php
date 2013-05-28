<?php

namespace Google\Client\GCM;

use Google\Client\GCM\Message\PayloadMessage;
use Network\Http\HttpClientErrorCodeException;
use Network\Http\HttpServerErrorCodeException;
use \Network\Http\Request;

/**
 * 
 * @author alxmsl
 * @date 5/26/13
 */ 
final class Client {

    const CONTENT_TYPE_JSON = 'application/json',
            CONTENT_TYPE_PLAIN_TEXT = 'application/x-www-form-urlencoded; charset=UTF-8';

    const ENDPOINT_SEND = 'https://android.googleapis.com/gcm/send';

    private $authorizationKey = '';

    private $Request = null;

    /**
     * @param string $authorizationKey
     * @return Client
     */
    public function setAuthorizationKey($authorizationKey)
    {
        $this->authorizationKey = (string) $authorizationKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorizationKey()
    {
        return $this->authorizationKey;
    }

    private function getRequest() {
        if (is_null($this->Request)) {
            $this->Request = new Request();
            $this->Request->setTransport(Request::TRANSPORT_CURL);
            $this->Request->setUrl(self::ENDPOINT_SEND);
        }
        return $this->Request;
    }

    public function send(PayloadMessage $Message) {
        $this->getRequest()->addHeader('Authorization', 'key=' . $this->getAuthorizationKey());
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

class GCMException extends \Exception {}
final class GCMFormatException extends GCMException {}
final class GCMUnauthorizedException extends GCMException {}