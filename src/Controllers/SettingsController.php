<?php

/*
 * This file is part of the dreamerivercn/oauth2-flarum extension.
 *
 * (c) 江愿文化 <support@dreameriver.cn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dreamerivercn\OAuth\Controllers;

use Flarum\Settings\SettingsRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class SettingsController implements RequestHandlerInterface
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // 处理POST请求保存设置
        if ($request->getMethod() === 'POST') {
            $params = $request->getParsedBody();
            
            $this->settings->set('dreamerivercn-oauth.client_id', $params['dreamerivercn-oauth.client_id'] ?? '');
            $this->settings->set('dreamerivercn-oauth.client_secret', $params['dreamerivercn-oauth.client_secret'] ?? '');
            $this->settings->set('dreamerivercn-oauth.auth_url', $params['dreamerivercn-oauth.auth_url'] ?? 'https://auth.dreameriver.cn');
            
            // 重定向到设置页面
            return new HtmlResponse('<script>window.location.reload();</script>');
        }

        // 显示设置页面
        ob_start();
        include __DIR__ . '/../../views/settings.blade.php';
        $content = ob_get_clean();

        return new HtmlResponse($content);
    }
}