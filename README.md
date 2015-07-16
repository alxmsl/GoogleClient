GoogleClient
===

[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](http://www.apache.org/licenses/LICENSE-2.0)
[![Build Status](https://travis-ci.org/alxmsl/GoogleClient.png?branch=master)](http://travis-ci.org/alxmsl/GoogleClient)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alxmsl/GoogleClient/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alxmsl/GoogleClient/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/alxmsl/GoogleClient/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alxmsl/GoogleClient/?branch=master)

Google services API library. 
Supported APIs:

* [OAuth2 authorization API](/README.md#oauth2)
* [Google Cloud Messaging API](/README.md#gcm)
* Android Publisher API: [in-app products](/README.md#inapp), [purchases products](/README.md#products) and 
 [purchases subscriptions](/README.md#subscriptions)

Installation
---

For install library you need to modify your composer configuration file

```
    "alxmsl/googleclient": "*"
```

And just run installation command

```
    $ composer.phar install
```

## <a name="oauth2"></a> OAuth2 authorization

To authorize client via [Google OAuth2](https://developers.google.com/android-publisher/authorization) you need to 
 create [WebServerApplication](/source/OAuth2/WebServerApplication.php) instance with needed scopes using client 
 identifier, client secret and redirect uri from you console
  
```
    $Client = new WebServerApplication();
    $Client->setClientId(<client id>)
        ->setClientSecret(<client secret>)
        ->setRedirectUri(<redirect uri>);
```

...make authentication url

```
    $Client->createAuthUrl([
            'https://www.googleapis.com/auth/androidpublisher',
        ]
        , ''
        , WebServerApplication::RESPONSE_TYPE_CODE
        , WebServerApplication::ACCESS_TYPE_OFFLINE
        , WebServerApplication::APPROVAL_PROMPT_FORCE);
```

...compete authorization in browser and give authorization code. With this code you could get access token
 
```
    $Token = $Client->authorizeByCode(<code>);
    print((string) $Token);
```

You could see examples [webclient.uri.php](/examples/webclient.uri.php) about uri creation, and 
 [webclient.authorize.php](/examples/webclient.authorize.php) about code authentication. Already you could use completed 
 script [authorize.php](/bin/authorize.php)
 
```
$ php bin/authorize.php
Using: /usr/local/bin/php bin/authorize.php [-h|--help] [-o|--code] -c|--client -r|--redirect -s|--scopes -e|--secret
-h, --help  - show help
-o, --code  - authorization code
-c, --client  - client id
-r, --redirect  - redirect uri
-s, --scopes  - grant scopes
-e, --secret  - client secret

$ php bin/authorize.php --client='my-client@id' --secret='clientsecret' --redirect='http://example.com/oauth2callback' 
    --scopes='https://www.googleapis.com/auth/androidpublisher'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=my-client@id
&redirect_uri=http%3A%2F%2Fexample.com%2Foauth2callback&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher
&access_type=offline&approval_prompt=force

$ php bin/authorize.php --client='my-client@id' --secret='clientsecret' --code='authorization/code'
    access token:  ya.AccES5_T0keN
    expires in:    3558
    id token:      id.T0kEn
    refresh token: refrE5H_T0KEN
    token type:    Bearer

```

Of course, I created scripts for token refreshing

```
$ php bin/refresh.php
Using: /usr/local/bin/php bin/refresh.php [-h|--help] -c|--client -e|--secret -t|--token
-h, --help  - show help
-c, --client  - client id
-e, --secret  - client secret
-t, --token  - refresh token
```

...and token revoking
 
```
$ php bin/revoke.php --help
Using: /usr/local/bin/php bin/revoke.php [-h|--help] -t|--token
-h, --help  - show help
-t, --token  - revoked token
```

## <a name="gcm"></a> Google Cloud Messaging

For create [Google Cloud Message](https://developer.android.com/google/gcm/index.html) you need to create child for 
 class [PayloadData](/source/GCM/Message/PayloadData.php) and define `getDataFields` method. You could see example below 
 or in [gcm.php](/examples/gcm.php)
 
```
    // Create payload data class
    final class NewPayloadData extends PayloadData {
        protected function getDataFields() {
            return [
                'test' => 'test_01',
            ];
        }
    }
    
    // Create and initialize payload message instance
    $Message = new PayloadMessage();
    $Message->setRegistrationIds('DeV1CeT0kEN')
        ->setType(PayloadMessage::TYPE_JSON)
        ->setData(new NewPayloadData());
    
    // Create GCM client
    $Client = new Client();
    $Client->getRequest()->setConnectTimeout(60)
        ->setSslVersion(6);
    $Client->setAuthorizationKey('aUTH0R1Z4t1oNKEy');
    
    // ...and send the message
    $Response = $Client->send($Message);
    var_dump($Response);
```

You could use [completed script](/bin/gcm.php)

```
$ php bin/gcm.php
Using: /usr/local/bin/php bin/gcm.php [-h|--help] [-d|--data] -i|--id -k|--key
-h, --help  - show help
-d, --data  - payload data
-i, --id  - device registration id
-k, --key  - authorization key

$ php bin/gcm.php --id='DeV1CeT0kEN' --key='aUTH0R1Z4t1oNKEy' --data='{"test":"test_01"}'
    success: 1
    failure: 0
```

## <a name="inapp"></a> In-app purchases

You could use [In-App products API](https://developers.google.com/android-publisher/api-ref/inappproducts) to manage 
 products of your application. For example, you could get all product prices for all end-user countries
 
```
    $Client = new Client();
    $Client->setPackage(<package name>)
        ->setAccessToken(<access token>);
    /** @var InAppProductsResource $Resource */
    $Resource = $Client->get(<product id>);
    var_dump($Resource->getPrices());
```

Already, you could use [inappproducts.get.php](/bin/inappproducts.get.php) to get info about products
 
```
$ php bin/inappproducts.get.php --help
Using: /usr/local/bin/php bin/inappproducts.get.php [-h|--help] -a|--access [-p|--package] -r|--product
-h, --help  - show help
-a, --access  - access token
-p, --package  - package name
-r, --product  - product id
```

## <a name="products"></a> Purchases products 

Using [Purchases.Products API]() you could check user purchases in third-party server application. For example if 
 purchase purchased and does not cancel now:

```
    use alxmsl\Google\AndroidPublisher\Purchases\Client;
    use alxmsl\Google\AndroidPublisher\Purchases\Products\Resource as ProductsResource;

    $Client = new Client();
    $Client->setPackage(<package name>)
        ->setAccessToken(<access token>);
    
    /** @var ProductsResource $Resource */
    $Resource = $Client->get(<product id>, <purchase token>);
    var_dump($Resource->isPurchased() && !$Resource->isCancelled());
```

## <a name="subscriptions"></a> Purchases subscriptions 

This library allows all operations over user 
 [subscriptions](https://developers.google.com/android-publisher/api-ref/purchases/subscriptions) using some scripts: 
 [get](/bin/subscriptions.get.php), [cancel](/bin/subscriptions.cancel.php), [defer](/bin/subscriptions.defer.php), 
 [refund](/bin/subscriptions.refund.php) and [revoke](/bin/subscriptions.revoke.php)

How to check subscription, for example:

```
    use alxmsl\Google\AndroidPublisher\Purchases\Subscription\Resource as SubscriptionsResource;
    use alxmsl\Google\AndroidPublisher\Purchases\Subscription\SubscriptionsClient;
    
    $Client = new SubscriptionsClient();
    $Client->setPackage(<package name>)
        ->setAccessToken(<access token>);
    
    /** @var SubscriptionsResource $Resource */
    $Resource = $Client->get(<subscription id>, <purchase token>);
    var_dump($Resource->isAutoRenewing() && !$Resource->isExpired());
```

Tests
---

For completely tests running just call `phpunit` command

```
    $ phpunit
    PHPUnit 4.7.3 by Sebastian Bergmann and contributors.

    ..........................................
    
    Time: 118 ms, Memory: 7.25Mb
    
    OK (42 tests, 365 assertions)
```

License
-------

Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
