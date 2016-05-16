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

namespace alxmsl\Google\AndroidPublisher\Purchases\Subscriptions;

use alxmsl\Google\AndroidPublisher\Exception\ErrorException;
use alxmsl\Google\AndroidPublisher\Exception\InvalidCredentialsException;
use alxmsl\Google\AndroidPublisher\Purchases\ClientInterface;
use alxmsl\Network\Exception\TransportException;
use UnexpectedValueException;

/**
 * Google Subscriptions API interface
 * @author alxmsl
 */
interface SubscriptionsClientInterface extends ClientInterface {
    /**
     * Cancel subscription method
     * @param string $productId product identifier
     * @param string $token purchase product token
     * @return bool if subscriptions removed correctly returns TRUE
     * @throws InvalidCredentialsException when access grants is not granted
     * @throws ErrorException when API error acquired
     * @throws TransportException when HTTP transport error occurred
     * @throws UnexpectedValueException when access token is empty for client
     */
    public function cancel($productId, $token);

    /**
     * Defer subscription method
     * @param string $productId product identifier
     * @param int $expectedTimeMillis expected subscription expiration time, milliseconds
     * @param int $desiredTimeMillis desired subscription expiration time, milliseconds
     * @param string $token purchase product token
     * @return int new expiration time, milliseconds
     * @throws InvalidCredentialsException when access grants is not granted
     * @throws ErrorException when API error acquired
     * @throws TransportException when HTTP transport error occurred
     * @throws UnexpectedValueException when access token is empty for client
     */
    public function defer($productId, $expectedTimeMillis, $desiredTimeMillis, $token);

    /**
     * Refund subscription method
     * @param string $productId product identifier
     * @param string $token purchase product token
     * @return bool if subscriptions refunded correctly returns TRUE
     * @throws InvalidCredentialsException when access grants is not granted
     * @throws ErrorException when API error acquired
     * @throws TransportException when HTTP transport error occurred
     * @throws UnexpectedValueException when access token is empty for client
     */
    public function refund($productId, $token);

    /**
     * Revoke subscription method
     * @param string $productId product identifier
     * @param string $token purchase product token
     * @return bool if subscriptions revoked correctly returns TRUE
     * @throws InvalidCredentialsException when access grants is not granted
     * @throws ErrorException when API error acquired
     * @throws TransportException when HTTP transport error occurred
     * @throws UnexpectedValueException when access token is empty for client
     */
    public function revokeSubscription($productId, $token);
}
