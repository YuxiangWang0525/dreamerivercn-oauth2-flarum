<?php

/*
 * This file is part of the dreamerivercn/oauth2-flarum extension.
 *
 * (c) 江愿文化 <support@dreameriver.cn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Flarum\Extend;
use Flarum\Forum\Controller\LogInController;
use Flarum\Forum\Controller\RegisterController;
use Dreamerivercn\OAuth\Controllers\SettingsController;

return [
    (new Extend\Frontend('admin'))
        ->css(__DIR__.'/less/admin.less'),

    (new Extend\Frontend('forum'))
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Routes('admin'))
        ->get('/dreamerivercn/oauth2/settings', 'dreamerivercn.oauth2.settings', SettingsController::class),

    (new Extend\Routes('forum'))
        ->get('/auth/dreamerivercn', 'auth.dreamerivercn', LogInController::class),

    (new Extend\Routes('forum'))
        ->get('/register/dreamerivercn', 'register.dreamerivercn', RegisterController::class),

    (new Extend\Settings())
        ->serializeToForum('dreamerivercnAuthUrl', 'dreamerivercn-oauth.auth_url')
        ->default('dreamerivercn-oauth.auth_url', 'https://auth.dreameriver.cn'),

    new Extend\Locales(__DIR__ . '/locale'),
];