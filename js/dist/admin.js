'use strict';

app.initializers.add('dreamerivercn/oauth2-flarum', function(app) {
  console.log('Dreameriver.cn OAuth2 Flarum插件管理端已加载');
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
});