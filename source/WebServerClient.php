<?php

namespace Google\Client;

/**
 * Class for login via web server applications
 * @author alxmsl
 * @date 1/13/13
 */ 
final class WebServerClient extends Client {
    /**
     * Google Api endpoints
     */
    const   ENDPOINT_INITIAL_REQUEST = 'https://accounts.google.com/o/oauth2/auth',
            ENDPOINT_ACCESS_TOKEN_REQUEST = 'https://accounts.google.com/o/oauth2/token';

    /**
     * Method for create authorization url
     * @param string[] $scopes set of permissions
     * @param string $state something state
     * @param string $responseType type of the response
     * @param string $accessType type of the access. Online or offline
     * @param string $approvalPrompt type of re-prompted user consent
     * @return string url string for user authorization
     */
    public function createAuthUrl(array $scopes, $state = '', $responseType = Client::RESPONSE_TYPE_CODE, $accessType = Client::ACCESS_TYPE_ONLINE, $approvalPrompt = Client::APPROVAL_PROMPT_AUTO) {
        $parameters = array(
            'response_type=' . $responseType,
            'client_id=' . $this->getClientId(),
            'redirect_uri=' . $this->getRedirectUri(),
            'scope=' . implode(' ', $scopes),
            'state=' . $state,
            'access_type=' . $accessType,
            'approval_prompt=' . $approvalPrompt,
        );
        return self::ENDPOINT_INITIAL_REQUEST . '?' . implode('&', $parameters);
    }

    /**
     * Method for get access token by user authorization code
     * @param string $code user authorization code
     * @return WebServerClientErrorResponse|WebServerClientResponse Google Api response object
     */
    public function getAccessToken($code) {
        $Request = $this->getRequest(self::ENDPOINT_ACCESS_TOKEN_REQUEST);
        $Request->addPostField('code', $code)
            ->addPostField('client_id', $this->getClientId())
            ->addPostField('client_secret', $this->getClientSecret())
            ->addPostField('redirect_uri', $this->getRedirectUri())
            ->addPostField('grant_type', self::GRANT_TYPE_AUTHORIZATION);
        try {
            return WebServerClientResponse::initializeByString($Request->send());
        } catch (\Network\Http\HttpClientErrorCodeException $ex) {
            return WebServerClientErrorResponse::initializeByString($ex->getMessage());
        }
    }

    //TODO: Метод обновления токена доступа по токену обновления
    public function refreshAccessToken($refreshToken) {

    }
}
