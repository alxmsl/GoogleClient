<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\GCM;
use alxmsl\Google\GCM\Exception\GCMFormatException;
use alxmsl\Google\GCM\Exception\GCMServerError;
use alxmsl\Google\GCM\Exception\GCMUnauthorizedException;
use alxmsl\Google\GCM\Exception\GCMUnrecoverableError;
use alxmsl\Google\GCM\Message\PayloadMessage;
use alxmsl\Google\GCM\Response\Response;
use alxmsl\Network\Http\HttpClientErrorCodeException;
use alxmsl\Network\Http\HttpServerErrorCodeException;
use alxmsl\Network\Http\Request;

/**
 * GCM sender client class
 * @author alxmsl
 * @date 5/26/13
 */ 
final class Client {
    /**
     * Supported content types
     */
    const CONTENT_TYPE_JSON       = 'application/json',
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
     * @throws GCMServerError when something wrong on the GCM server
     * @throws GCMUnrecoverableError when GCM server is not available
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
                throw new GCMFormatException('unsupported request format code \'' . $Message->getType() . '\'');
        }
        $this->getRequest()->setPostData($Message->export());
        try {
            $result = $this->getRequest()->send();
            Response::$type = $Message->getType();
            return Response::initializeByString($result);
        } catch (HttpClientErrorCodeException $Ex) {
            switch ($Ex->getCode()) {
                case '400':
                    throw new GCMFormatException('invalid JSON request with message \'' . $Ex->getMessage() . '\'');
                case '401':
                    throw new GCMUnauthorizedException('invalid authorization key \'' . $this->getAuthorizationKey() . '\'');
                default:
                    throw $Ex;
            }
        } catch (HttpServerErrorCodeException $Ex) {
            switch ($Ex->getCode()) {
                case '500':
                    throw new GCMUnrecoverableError('unrecoverable GCM server error');
                default:
                    $headers = $this->getRequest()->getResponseHeaders();
                    throw new GCMServerError(@$headers['Retry-After']);
            }
        }
    }
}
