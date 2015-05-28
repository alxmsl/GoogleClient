<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\AndroidPublisher\Purchases;

use alxmsl\Google\AndroidPublisher\Exception\ErrorException;
use alxmsl\Google\AndroidPublisher\Exception\InvalidCredentialsException;
use alxmsl\Google\AndroidPublisher\Purchases\Products\Resource as ProductResource;
use alxmsl\Google\AndroidPublisher\Purchases\Subscriptions\Resource as SubscriptionResource;
use alxmsl\Google\OAuth2\WebServerApplication;
use alxmsl\Network\Exception\HttpClientErrorCodeException;
use alxmsl\Network\Exception\HttpServerErrorCodeException;
use UnexpectedValueException;
use RuntimeException;

/**
 * Class for support GooglePlay Purchases API
 * @author alxmsl
 */
class Client extends WebServerApplication implements ClientInterface {
    /**
     * API client code
     */
    const TYPE_PRODUCTS      = 0,
          TYPE_SUBSCRIPTIONS = 1;

    /**
     * Google Purchases API uri parts
     */
    const URI_PRODUCTS      = 'products',
          URI_SUBSCRIPTIONS = 'subscriptions';

    /**
     * GooglePlay Purchases Products API endpoint
     */
    const ENDPOINT_PURCHASES = 'https://www.googleapis.com/androidpublisher/v2';

    /**
     * @var string package name
     */
    private $package = '';

    /**
     * @var string purchases type code
     */
    private $typeCode = self::TYPE_PRODUCTS;

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
     * @param int $typeCode client type code, Products or subscription
     */
    public function __construct($typeCode = self::TYPE_PRODUCTS) {
        $this->typeCode = (int) $typeCode;
    }

    /**
     * @inheritdoc
     */
    public function get($productId, $token) {
        $accessToken = $this->getAccessToken();
        if (!empty($accessToken)) {
            $Request = $this->getRequest(self::ENDPOINT_PURCHASES)
                ->addUrlField('applications', $this->getPackage())
                ->addUrlField($this->getPurchasesUri(), '')
                ->addUrlField('products', $productId)
                ->addUrlField('tokens', $token)
                ->addGetField('access_token', $accessToken);
            try {
                switch ($this->typeCode) {
                    case self::TYPE_PRODUCTS:
                        return ProductResource::initializeByString($Request->send());
                    case self::TYPE_SUBSCRIPTIONS:
                        return SubscriptionResource::initializeByString($Request->send());
                    default:
                        throw new RuntimeException(sprintf('type code %s not supported now', $this->typeCode));
                }
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

    /**
     * @return string purchases API uri string for client type
     */
    private function getPurchasesUri() {
        return $this->typeCode == self::TYPE_PRODUCTS
            ? self::URI_PRODUCTS
            : self::URI_SUBSCRIPTIONS;
    }
}
