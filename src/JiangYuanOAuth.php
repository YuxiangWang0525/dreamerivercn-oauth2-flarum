<?php

/*
 * This file is part of the jiangyuan/oauth2-flarum extension.
 *
 * (c) 江愿文化 <support@dreameriver.cn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JiangYuan\OAuth;

use Flarum\Extend;
use Flarum\Forum\AuthenticationResponseFactory;
use Flarum\Forum\LogInValidator;
use Flarum\Http\AccessToken;
use Flarum\Http\RememberAccessToken;
use Flarum\Http\Rememberer;
use Flarum\User\LoginProvider;
use Flarum\User\User;
use Flarum\User\UserValidator;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcher;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;
use Psr\Http\Message\ServerRequestInterface as Request;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken as OAuthToken;

class JiangYuanOAuth
{
    /**
     * @var AuthenticationResponseFactory
     */
    protected $authResponse;

    /**
     * @var LogInValidator
     */
    protected $validator;

    /**
     * @var UserValidator
     */
    protected $userValidator;

    /**
     * @var BusDispatcher
     */
    protected $bus;

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var Rememberer
     */
    protected $rememberer;

    /**
     * @param AuthenticationResponseFactory $authResponse
     * @param LogInValidator $validator
     * @param UserValidator $userValidator
     * @param BusDispatcher $bus
     * @param SettingsRepositoryInterface $settings
     * @param Rememberer $rememberer
     */
    public function __construct(
        AuthenticationResponseFactory $authResponse,
        LogInValidator $validator,
        UserValidator $userValidator,
        BusDispatcher $bus,
        SettingsRepositoryInterface $settings,
        Rememberer $rememberer
    ) {
        $this->authResponse = $authResponse;
        $this->validator = $validator;
        $this->userValidator = $userValidator;
        $this->bus = $bus;
        $this->settings = $settings;
        $this->rememberer = $rememberer;
    }

    /**
     * Handle OAuth2 authentication
     *
     * @param Request $request
     * @param array $providers
     * @return \Psr\Http\Message\ResponseInterface
     * @throws IdentityProviderException
     */
    public function handle(Request $request, array $providers)
    {
        $session = $request->getAttribute('session');
        $queryParams = $request->getQueryParams();
        $providerName = Arr::get($queryParams, 'provider');

        if (!array_key_exists($providerName, $providers)) {
            throw new \InvalidArgumentException('Invalid OAuth provider');
        }

        /** @var AbstractProvider $provider */
        $provider = $providers[$providerName];

        // If we already have an authorization code, we can try to get an access token
        $code = Arr::get($queryParams, 'code');
        if ($code) {
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $code
            ]);

            // Use the access token to get the user's details
            $user = $provider->getResourceOwner($token);
            
            // Find or create the user
            $flarumUser = $this->getUser($providerName, $user, $token);
            
            // Log the user in
            return $this->logIn($flarumUser, $request);
        } else {
            // If we don't have an authorization code yet, get one
            $authUrl = $provider->getAuthorizationUrl();
            $session->put('oauth2state', $provider->getState());
            
            return $this->authResponse->make($request, $session)->withHeader('Location', $authUrl)->withStatus(302);
        }
    }

    /**
     * Get or create a Flarum user based on the OAuth user details
     *
     * @param string $providerName
     * @param \League\OAuth2\Client\Provider\ResourceOwnerInterface $userDetails
     * @param OAuthToken $token
     * @return User
     */
    protected function getUser(string $providerName, $userDetails, OAuthToken $token)
    {
        // Try to find a user with this OAuth provider and identifier
        $loginProvider = LoginProvider::where('provider', $providerName)
            ->where('identifier', $userDetails->getId())
            ->first();

        if ($loginProvider) {
            // If we found a user, return it
            return $loginProvider->user;
        }

        // If we didn't find a user, try to find one with the same email
        $user = User::where('email', $userDetails->getEmail())->first();

        if (!$user) {
            // If we still didn't find a user, create a new one
            $user = $this->createUser($userDetails);
        }

        // Associate the OAuth provider with the user
        $user->loginProviders()->create([
            'provider' => $providerName,
            'identifier' => $userDetails->getId(),
        ]);

        return $user;
    }

    /**
     * Create a new Flarum user from OAuth user details
     *
     * @param \League\OAuth2\Client\Provider\ResourceOwnerInterface $userDetails
     * @return User
     */
    protected function createUser($userDetails)
    {
        // Generate a random password for the user
        $password = str_random(20);
        
        $user = User::build(
            $userDetails->getNickname() ?: $userDetails->getName(),
            $userDetails->getEmail(),
            $password
        );

        $user->activate();
        $user->save();

        return $user;
    }

    /**
     * Log the user in
     *
     * @param User $user
     * @param Request $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function logIn(User $user, Request $request)
    {
        $session = $request->getAttribute('session');
        $token = AccessToken::generate($user->id);
        $token->save();
        
        $response = $this->authResponse->make($request, $session, $token);

        if (Arr::get($request->getParsedBody(), 'remember')) {
            $response = $this->rememberer->remember($response, $token);
        }

        return $response;
    }
}