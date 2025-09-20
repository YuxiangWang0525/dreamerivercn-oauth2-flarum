(function() {
  'use strict';
  
  // 确保app对象存在
  if (typeof app === 'undefined') {
    console.error('Flarum app对象未定义');
    return;
  }

  app.initializers.add('dreamerivercn/oauth2-flarum', function() {
    // 极简版Dreameriver.cn OAuth2 Flarum插件管理端
    console.log('Dreameriver.cn OAuth2 Flarum插件管理端已加载');

    // 确保extensionData和相关方法存在
    if (app.extensionData && typeof app.extensionData.for === 'function') {
      app.extensionData
        .for('dreamerivercn/oauth2-flarum')
        .registerSetting({
          setting: 'dreamerivercn-oauth.client_id',
          label: app.translator.trans('dreamerivercn-oauth2-flarum.admin.settings.client_id_label'),
          help: app.translator.trans('dreamerivercn-oauth2-flarum.admin.settings.client_id_help'),
          type: 'input',
        })
        .registerSetting({
          setting: 'dreamerivercn-oauth.client_secret',
          label: app.translator.trans('dreamerivercn-oauth2-flarum.admin.settings.client_secret_label'),
          help: app.translator.trans('dreamerivercn-oauth2-flarum.admin.settings.client_secret_help'),
          type: 'input',
        })
        .registerSetting({
          setting: 'dreamerivercn-oauth.auth_url',
          label: app.translator.trans('dreamerivercn-oauth2-flarum.admin.settings.auth_url_label'),
          help: app.translator.trans('dreamerivercn-oauth2-flarum.admin.settings.auth_url_help'),
          type: 'input',
          defaultValue: 'https://auth.dreameriver.cn',
        });
    } else {
      console.warn('无法注册扩展设置项：extensionData API不可用');
    }
  });
})();