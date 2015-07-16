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

namespace alxmsl\Test\GoogleClient\AndroidPublisher\InAppProducts;

use alxmsl\Google\AndroidPublisher\InAppProducts\Date;
use alxmsl\Google\AndroidPublisher\InAppProducts\Listing;
use alxmsl\Google\AndroidPublisher\InAppProducts\Price;
use alxmsl\Google\AndroidPublisher\InAppProducts\Resource;
use alxmsl\Google\AndroidPublisher\InAppProducts\Season;
use PHPUnit_Framework_TestCase;

/**
 * In-App Products resource test class
 * @author alxmsl
 */
final class ResourceTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Date = new Date();
        $this->assertSame(0, $Date->getDay());
        $this->assertSame(0, $Date->getMonth());

        $Listing = new Listing();
        $this->assertEmpty($Listing->getDescription());
        $this->assertEmpty($Listing->getTitle());

        $Price = new Price();
        $this->assertEmpty($Price->getCurrency());
        $this->assertEmpty($Price->getPriceMicros());

        $Resource = new Resource();
        $this->assertEmpty($Resource->getDefaultLanguage());
        $this->assertNull($Resource->getDefaultPrice());
        $this->assertCount(0, $Resource->getListings());
        $this->assertEmpty($Resource->getPackageName());
        $this->assertCount(0, $Resource->getPrices());
        $this->assertEmpty($Resource->getPurchaseType());
        $this->assertNull($Resource->getSeason());
        $this->assertEmpty($Resource->getSku());
        $this->assertEmpty($Resource->getStatus());
        $this->assertEmpty($Resource->getSubscriptionPeriod());
        $this->assertEmpty($Resource->getTrialPeriod());
    }

    public function testInitialization() {
        $Resource = Resource::initializeByString('{
 "packageName": "com.example.example",
 "sku": "com.example.example.subscription",
 "status": "active",
 "purchaseType": "subscription",
 "defaultPrice": {
  "priceMicros": "2990000",
  "currency": "EUR"
 },
 "prices": {
  "AU": {
   "priceMicros": "4260000",
   "currency": "AUD"
  },
  "AT": {
   "priceMicros": "3590000",
   "currency": "EUR"
  },
  "BE": {
   "priceMicros": "3620000",
   "currency": "EUR"
  },
  "BO": {
   "priceMicros": "22330000",
   "currency": "BOB"
  },
  "BR": {
   "priceMicros": "10240000",
   "currency": "BRL"
  },
  "BG": {
   "priceMicros": "7020000",
   "currency": "BGN"
  },
  "CA": {
   "priceMicros": "4070000",
   "currency": "CAD"
  },
  "CL": {
   "priceMicros": "1996000000",
   "currency": "CLP"
  },
  "CO": {
   "priceMicros": "8320000000",
   "currency": "COP"
  },
  "CR": {
   "priceMicros": "1729000000",
   "currency": "CRC"
  },
  "CY": {
   "priceMicros": "3560000",
   "currency": "EUR"
  },
  "CZ": {
   "priceMicros": "99750000",
   "currency": "CZK"
  },
  "DK": {
   "priceMicros": "27930000",
   "currency": "DKK"
  },
  "EG": {
   "priceMicros": "24660000",
   "currency": "EGP"
  },
  "EE": {
   "priceMicros": "3590000",
   "currency": "EUR"
  },
  "FI": {
   "priceMicros": "3710000",
   "currency": "EUR"
  },
  "FR": {
   "priceMicros": "3590000",
   "currency": "EUR"
  },
  "DE": {
   "priceMicros": "3560000",
   "currency": "EUR"
  },
  "GR": {
   "priceMicros": "3680000",
   "currency": "EUR"
  },
  "HK": {
   "priceMicros": "25060000",
   "currency": "HKD"
  },
  "HU": {
   "priceMicros": "1135380000",
   "currency": "HUF"
  },
  "IN": {
   "priceMicros": "201070000",
   "currency": "INR"
  },
  "ID": {
   "priceMicros": "41986000000",
   "currency": "IDR"
  },
  "IE": {
   "priceMicros": "3680000",
   "currency": "EUR"
  },
  "IL": {
   "priceMicros": "12800000",
   "currency": "ILS"
  },
  "IT": {
   "priceMicros": "3650000",
   "currency": "EUR"
  },
  "JP": {
   "priceMicros": "387000000",
   "currency": "JPY"
  },
  "LB": {
   "priceMicros": "4873000000",
   "currency": "LBP"
  },
  "LT": {
   "priceMicros": "3620000",
   "currency": "EUR"
  },
  "LU": {
   "priceMicros": "3500000",
   "currency": "EUR"
  },
  "MY": {
   "priceMicros": "11870000",
   "currency": "MYR"
  },
  "MX": {
   "priceMicros": "48860000",
   "currency": "MXN"
  },
  "MA": {
   "priceMicros": "32030000",
   "currency": "MAD"
  },
  "NL": {
   "priceMicros": "3620000",
   "currency": "EUR"
  },
  "NZ": {
   "priceMicros": "4320000",
   "currency": "NZD"
  },
  "NO": {
   "priceMicros": "25830000",
   "currency": "NOK"
  },
  "PK": {
   "priceMicros": "329000000",
   "currency": "PKR"
  },
  "PE": {
   "priceMicros": "10010000",
   "currency": "PEN"
  },
  "PH": {
   "priceMicros": "143740000",
   "currency": "PHP"
  },
  "PL": {
   "priceMicros": "14940000",
   "currency": "PLN"
  },
  "PT": {
   "priceMicros": "3680000",
   "currency": "EUR"
  },
  "RO": {
   "priceMicros": "16380000",
   "currency": "RON"
  },
  "RU": {
   "priceMicros": "156000000",
   "currency": "RUB"
  },
  "SA": {
   "priceMicros": "12120000",
   "currency": "SAR"
  },
  "SG": {
   "priceMicros": "4400000",
   "currency": "SGD"
  },
  "SK": {
   "priceMicros": "3590000",
   "currency": "EUR"
  },
  "SI": {
   "priceMicros": "3650000",
   "currency": "EUR"
  },
  "ZA": {
   "priceMicros": "38620000",
   "currency": "ZAR"
  },
  "KR": {
   "priceMicros": "3542000000",
   "currency": "KRW"
  },
  "ES": {
   "priceMicros": "3620000",
   "currency": "EUR"
  },
  "SE": {
   "priceMicros": "34860000",
   "currency": "SEK"
  },
  "CH": {
   "priceMicros": "3120000",
   "currency": "CHF"
  },
  "TW": {
   "priceMicros": "101000000",
   "currency": "TWD"
  },
  "TH": {
   "priceMicros": "104870000",
   "currency": "THB"
  },
  "TR": {
   "priceMicros": "8390000",
   "currency": "TRY"
  },
  "UA": {
   "priceMicros": "75700000",
   "currency": "UAH"
  },
  "AE": {
   "priceMicros": "11870000",
   "currency": "AED"
  },
  "GB": {
   "priceMicros": "2620000",
   "currency": "GBP"
  },
  "US": {
   "priceMicros": "2990000",
   "currency": "USD"
  },
  "VN": {
   "priceMicros": "69767000000",
   "currency": "VND"
  }
 },
 "season": {
   "start": {
    "month": 7,
    "day": 15
   },
   "end": {
    "month": 8,
    "day": 15
   }
 },
 "listings": {
  "en-US": {
   "title": "Subscription: 1 month.",
   "description": "Subscription: 1 month."
  },
  "ru-RU": {
   "title": "Подписка на 1 месяц",
   "description": "Подписка на 1 месяц"
  }
 },
 "defaultLanguage": "en-US",
 "subscriptionPeriod": "P1M"
}');
        $this->assertEquals('com.example.example', $Resource->getPackageName());
        $this->assertEquals('com.example.example.subscription', $Resource->getSku());
        $this->assertEquals('active', $Resource->getStatus());
        $this->assertEquals('subscription', $Resource->getPurchaseType());
        $this->assertInstanceOf(Price::class, $Resource->getDefaultPrice());
        $this->assertEquals('2990000', $Resource->getDefaultPrice()->getPriceMicros());
        $this->assertEquals('EUR', $Resource->getDefaultPrice()->getCurrency());
        $this->assertCount(60, $Resource->getPrices());
        $this->assertCount(2, $Resource->getListings());
        $this->assertEquals('Subscription: 1 month.', $Resource->getListings()['en-US']->getTitle());
        $this->assertEquals('Subscription: 1 month.', $Resource->getListings()['en-US']->getDescription());
        $this->assertEquals('en-US', $Resource->getDefaultLanguage());
        $this->assertEquals('P1M', $Resource->getSubscriptionPeriod());
        $this->assertInstanceOf(Season::class, $Resource->getSeason());
        $this->assertInstanceOf(Date::class, $Resource->getSeason()->getStart());
        $this->assertEquals(7, $Resource->getSeason()->getStart()->getMonth());
        $this->assertEquals(15, $Resource->getSeason()->getStart()->getDay());
        $this->assertInstanceOf(Date::class, $Resource->getSeason()->getEnd());
        $this->assertEquals(8, $Resource->getSeason()->getEnd()->getMonth());
        $this->assertEquals(15, $Resource->getSeason()->getEnd()->getDay());

        $this->assertEquals('    language: en-US
    package:  com.example.example
    type:     subscription
    sku:      com.example.example.subscription
    status:   active', (string) $Resource);
    }
}
