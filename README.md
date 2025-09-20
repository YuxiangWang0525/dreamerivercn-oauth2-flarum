# Dreameriver.cn OAuth2 for Flarum

[![MIT license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/dreamerivercn/flarum-oauth2/blob/main/LICENSE)

Dreameriver.cn OAuth2登录插件，允许用户使用Dreameriver.cn账户登录Flarum论坛。

## 安装

使用 [Composer](https://getcomposer.org/) 安装:

```bash
composer require dreamerivercn/oauth2-flarum
```

## 配置

1. 进入Flarum管理后台
2. 启用"Dreameriver.cn OAuth2登录"插件
3. 点击插件设置按钮
4. 输入从Dreameriver.cn通行证获取的客户端ID和客户端密钥
5. 保存设置

## 使用

启用并配置插件后，用户可以在登录和注册页面看到"使用Dreameriver.cn通行证登录"按钮。点击该按钮将重定向到Dreameriver.cn通行证进行身份验证。

## 技术细节

- 基于OAuth2标准协议实现
- 使用`https://auth.dreameriver.cn`作为认证服务器地址
- 支持中英文界面

## 支持

如有问题，请联系 [support@dreameriver.cn](mailto:support@dreameriver.cn) 或在GitHub上提交issue。

## 许可证

MIT许可证。详情请见 [LICENSE](LICENSE) 文件。