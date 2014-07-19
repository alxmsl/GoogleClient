<?php

namespace alxmsl\Google\InAppPurchases;
use alxmsl\Google\InAppPurchases\Response\Error;
use alxmsl\Google\InAppPurchases\Response\Resource;
use alxmsl\Google\OAuth2\WebServerApplication;
use alxmsl\Network\Http\HttpClientErrorCodeException;
use alxmsl\Network\Http\HttpServerErrorCodeException;
use UnexpectedValueException;

/**
 * Class for support Google InApp Purchases API
 * @author alxmsl
 * @date 12/4/13
 */ 
final class InAppPurchases extends WebServerApplication {
    /**
     * Google Api InAppPurchases endpoint
     */
    const ENDPOINT_PURCHASES = 'https://www.googleapis.com/androidpublisher/v1.1';

    /**
     * @var string package name
     */
    private $package = '';

    /**
     * Setter for package name
     * @param string $package package name
     * @return InAppPurchases self
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
     * Check InApp purchase
     * @param string $productId product identifier
     * @param string $token InApp purchase token
     * @return Resource|Error InApp purchase resource or error instance
     * @throws UnexpectedValueException when access token not presented
     */
    public function get($productId, $token) {
        $accessToken = $this->getAccessToken();
        if (!empty($accessToken)) {
            $Request = $this->getRequest(self::ENDPOINT_PURCHASES)
                ->addUrlField('applications', $this->getPackage())
                ->addUrlField('inapp', $productId)
                ->addUrlField('purchases', $token)
                ->addGetField('access_token', $accessToken);
            try {
                return Resource::initializeByString($Request->send());
            } catch (HttpClientErrorCodeException $ex) {
                switch ($ex->getCode()) {
                    case 400:
                    case 401:
                    case 404:
                        $Error = Error::initializeByString($ex->getMessage());
                        if ($Error->getCode()) {
                            return $Error;
                        } else {
                            throw $ex;
                        }
                    default:
                        throw $ex;
                }
            } catch (HttpServerErrorCodeException $ex) {
                switch ($ex->getCode()) {
                    case 500:
                        return Error::initializeByString($ex->getMessage());
                    default:
                        throw $ex;
                }
            }
        } else {
            throw new UnexpectedValueException('access token is empty');
        }
    }
}
 