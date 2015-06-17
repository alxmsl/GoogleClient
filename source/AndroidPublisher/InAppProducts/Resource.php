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

use alxmsl\Google\InitializationInterface;

/**
 * Class of in-app product purchase resource
 * @author alxmsl
 */
final class Resource implements InitializationInterface {
    /**
     * @var string default language of the localized data BCP 47
     */
    private $defaultLanguage = '';

    /**
     * @var null|Price default in-app product price
     */
    private $defaultPrice = null;

    /**
     * @var Listing[] language of the localized data, specified with a BCP 47 language
     */
    private $listings = [];

    /**
     * @var string package name of the parent app
     */
    private $packageName = '';

    /**
     * @var Price[] prices per buyer region
     */
    private $prices = [];

    /**
     * @var string purchase type enum value
     */
    private $purchaseType = '';

    /**
     * @var Season|null season for a seasonal subscription
     */
    private $season = null;

    /**
     * @var string stock-keeping-unit of the product
     */
    private $sku = '';

    /**
     * @var string in-app product status
     */
    private $status = '';

    /**
     * @var string subscription period, specified in ISO 8601 format
     */
    private $subscriptionPeriod = '';

    /**
     * @var string trial period, specified in ISO 8601 format
     */
    private $trialPeriod = '';

    /**
     * @return string default language of the localized data BCP 47
     */
    public function getDefaultLanguage() {
        return $this->defaultLanguage;
    }

    /**
     * @return null|Price default in-app product price
     */
    public function getDefaultPrice() {
        return $this->defaultPrice;
    }

    /**
     * @return Listing[] language of the localized data, specified with a BCP 47 language
     */
    public function getListings() {
        return $this->listings;
    }

    /**
     * @return string package name of the parent app
     */
    public function getPackageName() {
        return $this->packageName;
    }

    /**
     * @return Price[] prices per buyer region
     */
    public function getPrices() {
        return $this->prices;
    }

    /**
     * @return string purchase type enum value
     */
    public function getPurchaseType() {
        return $this->purchaseType;
    }

    /**
     * @return Season|null season for a seasonal subscription
     */
    public function getSeason() {
        return $this->season;
    }

    /**
     * @return string stock-keeping-unit of the product,
     */
    public function getSku() {
        return $this->sku;
    }

    /**
     * @return string in-app product status
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return string subscription period, specified in ISO 8601 format
     */
    public function getSubscriptionPeriod() {
        return $this->subscriptionPeriod;
    }

    /**
     * @return string trial period, specified in ISO 8601 format
     */
    public function getTrialPeriod() {
        return $this->trialPeriod;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByString($string) {
        $Object   = json_decode($string);
        $Resource = new Resource();

        $Resource->defaultLanguage    = (string) $Object->defaultLanguage;
        $Resource->defaultPrice       = Price::initializeByObject($Object->defaultPrice);
        $Resource->packageName        = (string) $Object->packageName;
        $Resource->purchaseType       = (string) $Object->purchaseType;
        $Resource->sku                = (string) $Object->sku;
        $Resource->status             = (string) $Object->status;
        $Resource->subscriptionPeriod = (string) @$Object->subscriptionPeriod;
        $Resource->trialPeriod        = (string) @$Object->trialPeriod;

        if (isset($Object->season)) {
            $Resource->season = Season::initializeByObject($Object->season);
        }
        foreach ($Object->listings as $key => $Item) {
            $Resource->listings[$key] = Listing::initializeByObject($Item);
        }
        foreach ($Object->prices as $key => $Item) {
            $Resource->prices[$key] = Price::initializeByObject($Item);
        }
        return $Resource;
    }

    /**
     * @inheritdoc
     */
    public function __toString() {
        $format = <<<'EOD'
    language: %s
    package:  %s
    type:     %s
    sku:      %s
    status:   %s
EOD;
        return sprintf($format
            , $this->getDefaultLanguage()
            , $this->getPackageName()
            , $this->getPurchaseType()
            , $this->getSku()
            , $this->getStatus());
    }
}
