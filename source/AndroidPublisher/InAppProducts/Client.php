<?php
/*
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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
