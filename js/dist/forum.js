(function() {
  'use strict';
  
  // 确保app对象存在
  if (typeof app === 'undefined') {
    console.error('Flarum app对象未定义');
    return;
  }

  app.initializers.add('dreamerivercn/oauth2-flarum', function() {
    console.log('Dreameriver.cn OAuth2 Flarum插件前端已加载');
  });
})();