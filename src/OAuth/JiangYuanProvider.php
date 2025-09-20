<?php

/*
 * This file is part of the jiangyuan/oauth2-flarum extension.
 *
 * (c) 江愿文化 <support@dreameriver.cn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JiangYuan\OAuth\OAuth;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class JiangYuanProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Base URL for the provider
     *
     * @var string
     */
    protected $baseAuthUrl = 'https://auth.dreameriver.cn';

    /**
     * Returns the base URL for authorizing a client.
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->baseAuthUrl . '/oauth/authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->baseAuthUrl . '/oauth/token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->baseAuthUrl . '/api/user';
    }

    /**
     * Returns the default scopes used by this provider.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return ['basic'];
    }

    /**
     * Checks a provider response for errors.
     *
     * @param ResponseInterface $response
     * @param array|string $data Parsed response data
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $data['error']['message'] ?? 'Unknown error',
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return JiangYuanResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new JiangYuanResourceOwner($response);
    }
}