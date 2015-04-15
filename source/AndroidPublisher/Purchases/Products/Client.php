<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\AndroidPublisher\Purchases\Products;
use alxmsl\Google\AndroidPublisher\Purchases\Exception\ErrorException;
use alxmsl\Google\OAuth2\WebServerApplication;
use alxmsl\Network\Exception\HttpClientErrorCodeException;
use alxmsl\Network\Exception\HttpServerErrorCodeException;
use UnexpectedValueException;

/**
 * Class for support GooglePlay Purchases Products API
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
     * Check user product purchases
     * @param string $productId product identifier
     * @param string $token purchase product token
     * @return Resource product purchase resource instance
     * @throws ErrorException when API error acquired
     */
    public function get($productId, $token) {
        $accessToken = $this->getAccessToken();
        if (!empty($accessToken)) {
            $Request = $this->getRequest(self::ENDPOINT_PURCHASES)
                ->addUrlField('applications', $this->getPackage())
                ->addUrlField('purchases', '')
                ->addUrlField('products', $productId)
                ->addUrlField('tokens', $token)
                ->addGetField('access_token', $accessToken);
            try {
                return Resource::initializeByString($Request->send());
            } catch (HttpClientErrorCodeException $Ex) {
                throw ErrorException::initializeByString($Ex->getMessage());
            } catch (HttpServerErrorCodeException $Ex) {
                throw ErrorException::initializeByString($Ex->getMessage());
            }
        } else {
            throw new UnexpectedValueException('access token is empty');
        }
    }
}
