<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\AndroidPublisher\Purchases\Subscriptions;

use alxmsl\Google\AndroidPublisher\Purchases\Client;
use alxmsl\Google\AndroidPublisher\Exception\ErrorException;
use alxmsl\Google\AndroidPublisher\Exception\InvalidCredentialsException;
use alxmsl\Network\Exception\HttpClientErrorCodeException;
use alxmsl\Network\Exception\HttpServerErrorCodeException;
use alxmsl\Network\Exception\TransportException;
use alxmsl\Network\Http\Request;
use UnexpectedValueException;

/**
 * Client for Google Play subscriptions API
 * @author alxmsl
 */
final class SubscriptionsClient extends Client implements SubscriptionsClientInterface {
    public function __construct() {
        parent::__construct(self::TYPE_SUBSCRIPTIONS);
    }

    /**
     * @inheritdoc
     */
    public function cancel($productId, $token) {
        $this->sendRequest('cancel', $productId, $token);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function defer($productId, $expectedTimeMillis, $desiredTimeMillis, $token) {
        $Request = $this->createRequest('defer', $productId, $token)
            ->setPostData(json_encode([
                'deferralInfo' => [
                    'expectedExpiryTimeMillis' => $expectedTimeMillis,
                    'desiredExpiryTimeMillis'  => $desiredTimeMillis,
                ],
            ]));
        $response = $this->makeRequest($Request);
        $Object   = json_decode($response);
        return $Object->newExpiryTimeMillis;
    }

    /**
     * @inheritdoc
     */
    public function refund($productId, $token) {
        $this->sendRequest('refund', $productId, $token);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function revoke($productId, $token) {
        $this->sendRequest('revoke', $productId, $token);
        return true;
    }

    /**
     * Send command for Purchases Subscriptions API
     * @param string $command subscriptions API command
     * @param string $productId product identifier
     * @param string $token purchase product token
     * @return string API response body
     * @throws InvalidCredentialsException when access grants is not granted
     * @throws ErrorException when API error acquired
     * @throws TransportException when HTTP transport error occurred
     * @throws UnexpectedValueException when access token is empty for client
     */
    private function sendRequest($command, $productId, $token) {
        return $this->makeRequest($this->createRequest($command, $productId, $token));
    }

    /**
     * Send command for Purchases Subscriptions API
     * @param Request $Request request instance
     * @return string API response body
     * @throws InvalidCredentialsException when access grants is not granted
     * @throws ErrorException when API error acquired
     * @throws TransportException when HTTP transport error occurred
     * @throws UnexpectedValueException when access token is empty for client
     */
    private function makeRequest(Request $Request) {
        $accessToken = $this->getAccessToken();
        if (!empty($accessToken)) {
            try {
                return $Request->send();
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
     * Create request instance for command
     * @param string $command subscriptions API command
     * @param string $productId product identifier
     * @param string $token purchase product token
     * @return Request HTTP request instance
     */
    private function createRequest($command, $productId, $token) {
        $Request = $this->getRequest(self::ENDPOINT_PURCHASES)
            ->addUrlField('applications', $this->getPackage())
            ->addUrlField(self::URI_SUBSCRIPTIONS, '')
            ->addUrlField('products', $productId)
            ->addUrlField('tokens', $token)
            ->addUrlField(sprintf(':%s', $command), '')
            ->addGetField('access_token', $this->getAccessToken());
        $Request->setMethod(Request::METHOD_POST);
        return $Request;
    }
}
