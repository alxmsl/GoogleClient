<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\OAuth2;
use alxmsl\Network\Http\Request;

/**
 * Abstract Google client class
 * @author alxmsl
 * @date 1/13/13
 */ 
abstract class Client {
    /**
     * @var string client identifier
     */
    private $clientId = '';

    /**
     * @var string client secret
     */
    private $clientSecret = '';

    /**
     * @var string redirect uri
     */
    private $redirectUri = '';

    /**
     * @var string access token
     */
    private $accessToken = '';

    /**
     * @var int connect timeout, seconds
     */
    private $connectTimeout = 0;

    /**
     * @var int request timeout, seconds
     */
    private $requestTimeout = 0;

    /**
     * Getter for the request
     * @param string $url request url
     * @return Request request object
     */
    protected function getRequest($url) {
        $Request = new Request();
        $Request->setTransport(Request::TRANSPORT_CURL);
        return $Request->setUrl($url)
            ->setConnectTimeout($this->getConnectTimeout())
            ->setTimeout($this->getRequestTimeout());
    }

    /**
     * Setter for client identifier
     * @param string $clientId client identifier
     * @return Client self
     */
    public function setClientId($clientId) {
        $this->clientId = (string) $clientId;
        return $this;
    }

    /**
     * Getter for client identifier
     * @return string client identifier
     */
    public function getClientId() {
        return $this->clientId;
    }

    /**
     * Setter for client secret code
     * @param string $clientSecret client secret code
     * @return Client self
     */
    public function setClientSecret($clientSecret) {
        $this->clientSecret = (string) $clientSecret;
        return $this;
    }

    /**
     * Getter for client secret code
     * @return string client secret code
     */
    public function getClientSecret() {
        return $this->clientSecret;
    }

    /**
     * Setter for redirect url
     * @param string $redirectUri redirect ur;
     * @return Client self
     */
    public function setRedirectUri($redirectUri) {
        $this->redirectUri = (string) $redirectUri;
        return $this;
    }

    /**
     * Getter for redirect url
     * @return string redirect url
     */
    public function getRedirectUri() {
        return $this->redirectUri;
    }

    /**
     * Setter for access token value
     * @param string $accessToken access token value
     * @return Client self
     */
    public function setAccessToken($accessToken) {
        $this->accessToken = (string) $accessToken;
        return $this;
    }

    /**
     * Getter for access token value
     * @return string access token value
     */
    public function getAccessToken() {
        return $this->accessToken;
    }

    /**
     * Setter for connect timeout value
     * @param int $connectTimeout connect timeout, seconds
     * @return Client self
     */
    public function setConnectTimeout($connectTimeout) {
        $this->connectTimeout = (int) $connectTimeout;
        return $this;
    }

    /**
     * Getter for connect timeout value
     * @return int connect timeout, seconds
     */
    public function getConnectTimeout() {
        return $this->connectTimeout;
    }

    /**
     * Setter for request timeout value
     * @param int $requestTimeout request timeout, seconds
     * @return Client self
     */
    public function setRequestTimeout($requestTimeout) {
        $this->requestTimeout = (int) $requestTimeout;
        return $this;
    }

    /**
     * Getter for request timeout value
     * @return int request timeout, seconds
     */
    public function getRequestTimeout() {
        return $this->requestTimeout;
    }
}
