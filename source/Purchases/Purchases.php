<?php

namespace Google\Client\Purchases;

use \Google\Client\OAuth2\WebServerApplication,
    \Google\Client\Purchases\Response\Resource,
    Google\Client\Purchases\Response\Error,
    \Network\Http\Request;

/**
 * Class for support Google Purchases Api
 * @author alxmsl
 * @date 2/9/13
 */ 
final class Purchases extends WebServerApplication {
    /**
     * Google Api Purchases endpoints
     */
    const ENDPOINT_PURCHASES = 'https://www.googleapis.com/androidpublisher/v1';

    /**
     * @var string package name
     */
    private $package = '';

    /**
     * Setter for package name
     * @param string $package package name
     * @return Purchases self
     */
    public function setPackage($package) {
        $this->package = (string) $package;
        return $this;
    }

    /**
     * Getter for package name
     * @return string package name
     */
    public function getPackage() {
        return $this->package;
    }

    /**
     * Check user subscription
     * @param string $productId product identifier
     * @param string $subscriptionId subscription identifier
     * @return Resource|Error user subscription data
     * @throws \UnexpectedValueException when access token not presented
     */
    public function get($productId, $subscriptionId) {
        $accessToken = $this->getAccessToken();
        if (!empty($accessToken)) {
            $Request = $this->getRequest(self::ENDPOINT_PURCHASES)
                ->addUrlField('applications', $this->getPackage())
                ->addUrlField('subscriptions', $productId)
                ->addUrlField('purchases', $subscriptionId)
                ->addGetField('access_token', $accessToken);
            try {
                return Resource::initializeByString($Request->send());
            } catch (\Network\Http\HttpClientErrorCodeException $ex) {
                return Error::initializeByString($ex->getMessage());
            }
        } else {
            throw new \UnexpectedValueException();
        }
    }

    /**
     * Cancel user subscription
     * @param string $productId product identifier
     * @param string $subscriptionId subscription identifier
     * @return bool|Error user subscription cancellation result
     * @throws \UnexpectedValueException when access token not presented
     */
    public function cancel($productId, $subscriptionId) {
        $accessToken = $this->getAccessToken();
        if (!empty($accessToken)) {
            $Request = $this->getRequest(self::ENDPOINT_PURCHASES)
                ->addUrlField('applications', $this->getPackage())
                ->addUrlField('subscriptions', $productId)
                ->addUrlField('purchases', $subscriptionId)
                ->addUrlField('cancel')
                ->addGetField('access_token', $accessToken);
            $Request->setMethod(Request::METHOD_POST);
            try {
                return $Request->send() === '';
            } catch (\Network\Http\HttpClientErrorCodeException $ex) {
                return Error::initializeByString($ex->getMessage());
            }
        } else {
            throw new \UnexpectedValueException();
        }
    }
}
