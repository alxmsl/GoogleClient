<?php
/**
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
 *
 * In-app products example
 * @author alxmsl
 * @date 5/28/13
 */

include '../vendor/autoload.php';

use alxmsl\Google\AndroidPublisher\InAppProducts\Client;
use alxmsl\Google\AndroidPublisher\InAppProducts\Resource as InAppProductsResource;

const PACKAGE_NAME = 'com.example.package',
      ACCESS_TOKEN = '4CcE5s_T0keN',
      PRODUCT_ID   = 'com.example.package.product.1';

$Client = new Client();
$Client->setPackage(PACKAGE_NAME)
    ->setAccessToken(ACCESS_TOKEN);
/** @var InAppProductsResource $Resource */
$Resource = $Client->get(PRODUCT_ID);
var_dump($Resource->getPrices());
