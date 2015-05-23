<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\AndroidPublisher\InAppProducts;

use alxmsl\Google\AndroidPublisher\Exception\ErrorException;
use alxmsl\Google\AndroidPublisher\Exception\InvalidCredentialsException;
use alxmsl\Google\OAuth2\WebServerApplication;
use alxmsl\Network\Exception\HttpClientErrorCodeException;
use alxmsl\Network\Exception\HttpServerErrorCodeException;
use UnexpectedValueException;
use RuntimeException;

/**
 * Class for support GooglePlay InAppProducts API
 * @author alxmsl
 */
final class Client extends WebServerApplication {
    /**
     * GooglePlay Purchases Products API endpoint
     */
    const ENDPOINT_PURCHASES = 'https://www.googleapis.com/androidpublisher/v2';

    /**
     * @var string package name
     */
    private $package = '';

    /**
     * @param string $package package name
     * @return $this
     */
    public function setPackage($package) {
        $this->package = (string) $package;
        return $this;
    }

    /**
     * @return string package name
     */
    public function getPackage() {
        return $this->package;
    }

    /**
     * Returns information about the in-app product specified
     * @param string $productId product identifier
     * @return Resource product purchase resource instance
     * @throws ErrorException when API error acquired
     * @throws RuntimeException when type code for client is not supported now
     */
    public function get($productId) {
        $accessToken = $this->getAccessToken();
        if (!empty($accessToken)) {
            $Request = $this->getRequest(self::ENDPOINT_PURCHASES)
                ->addUrlField('applications', $this->getPackage())
                ->addUrlField('inappproducts', $productId)
                ->addGetField('access_token', $accessToken);
            try {
                return Resource::initializeByString($Request->send());
            } catch (HttpClientErrorCodeException $Ex) {
                switch ($Ex->getCode()) {
                    case 401:
                        throw InvalidCredentialsException::initializeByString($Ex->getMessage());
                    default:
                        throw ErrorException::initializeByString($Ex->getMessage());
                }
            } catch (HttpServerErrorCodeException $Ex) {
                throw ErrorException::initializeByString($Ex->getMessage());
            }
        } else {
            throw new UnexpectedValueException('access token is empty');
        }
    }
}
