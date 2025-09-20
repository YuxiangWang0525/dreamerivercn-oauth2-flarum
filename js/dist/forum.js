'use strict';

app.initializers.add('dreamerivercn/oauth2-flarum', function(app) {
  console.log('Dreameriver.cn OAuth2 Flarum插件前端已加载');
  // 扩展登录按钮
  app.extensionUtils.extend('flarum/forum/components/LogInButtons', 'items', function (items) {
    items.add('dreamerivercn',
      <a className="Button LogInButton--dreamerivercn" href={app.route('auth.dreamerivercn')}>
        <i className="fas fa-sign-in-alt"></i> {app.translator.trans('dreamerivercn-oauth2-flarum.forum.log_in_with_dreamerivercn')}
      </a>
    );
    
    return items;
  });
});