<?php

namespace Google\Client;

use Network\Http\Request;

/**
 * Abstract Google client class
 * @author alxmsl
 * @date 1/13/13
 */ 
abstract class Client {
    /**
     * Response type constants
     */
    const   RESPONSE_TYPE_CODE  = 'code';

    /**
     * Access type constants
     */
    const   ACCESS_TYPE_ONLINE  = 'online',
            ACCESS_TYPE_OFFLINE = 'offline';

    /**
     * Approval constants
     */
    const   APPROVAL_PROMPT_AUTO    = 'auto',
            APPROVAL_PROMPT_FORCE   = 'force';

    /**
     * Grant type constants
     */
    const   GRANT_TYPE_AUTHORIZATION    = 'authorization_code',
            GRANT_TYPE_REFRESH          = 'refresh_token';

    /**
     * @var Request[] requests cache
     */
    private $requests = array();

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
        $key = md5($url);
        if (!isset($this->requests[$key])) {
            $Request = new Request();
            $Request->setUrl($url)
                ->setConnectTimeout($this->getConnectTimeout())
                ->setTimeout($this->getRequestTimeout());
            $Request->setTransport(Request::TRANSPORT_CURL);
            $this->requests[$key] = $Request;
        }
        return $this->requests[$key];
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
