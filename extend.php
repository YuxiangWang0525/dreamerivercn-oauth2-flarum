<?php

/*
 * This file is part of the jiangyuan/oauth2-flarum extension.
 *
 * (c) 江愿文化 <support@dreameriver.cn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Flarum\Extend;
use Flarum\Forum\Content\RegisterUser;
use Flarum\Forum\Controller\LogInController;
use Flarum\Forum\Controller\RegisterController;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Container\Container;
use JiangYuan\OAuth\JiangYuanOAuth;
use JiangYuan\OAuth\OAuth\JiangYuanProvider;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/less/admin.less'),

    (new Extend\Routes('forum'))
        ->get('/auth/jiangyuan', 'auth.jiangyuan', LogInController::class),

    (new Extend\Routes('forum'))
        ->get('/register/jiangyuan', 'register.jiangyuan', RegisterController::class)
        ->setContent(function (Container $container, RegisterUser $content) {
            $settings = $container->make(SettingsRepositoryInterface::class);
            
            $clientId = $settings->get('jiangyuan-oauth.client_id');
            $clientSecret = $settings->get('jiangyuan-oauth.client_secret');
            
            if ($clientId && $clientSecret) {
                // Add OAuth provider to the register page
                return $content;
            }
            
            return $content;
        }),

    (new Extend\Settings())
        ->serializeToForum('jiangyuanAuthUrl', 'jiangyuan-oauth.auth_url')
        ->default('jiangyuan-oauth.auth_url', 'https://auth.dreameriver.cn'),

    new Extend\Locales(__DIR__ . '/locale'),
];