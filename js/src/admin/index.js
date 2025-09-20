import app from 'flarum/admin/app';

app.initializers.add('jiangyuan/oauth2-flarum', () => {
  app.extensionData
    .for('jiangyuan-oauth2-flarum')
    .registerSetting({
      setting: 'jiangyuan-oauth.client_id',
      label: app.translator.trans('jiangyuan-oauth2-flarum.admin.settings.client_id_label'),
      help: app.translator.trans('jiangyuan-oauth2-flarum.admin.settings.client_id_help'),
      type: 'input',
    })
    .registerSetting({
      setting: 'jiangyuan-oauth.client_secret',
      label: app.translator.trans('jiangyuan-oauth2-flarum.admin.settings.client_secret_label'),
      help: app.translator.trans('jiangyuan-oauth2-flarum.admin.settings.client_secret_help'),
      type: 'input',
    })
    .registerSetting({
      setting: 'jiangyuan-oauth.auth_url',
      label: app.translator.trans('jiangyuan-oauth2-flarum.admin.settings.auth_url_label'),
      help: app.translator.trans('jiangyuan-oauth2-flarum.admin.settings.auth_url_help'),
      type: 'input',
      defaultValue: 'https://auth.dreameriver.cn',
    });
});