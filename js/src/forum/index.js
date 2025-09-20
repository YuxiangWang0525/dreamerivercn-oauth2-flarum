import { extend } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import LogInButtons from 'flarum/forum/components/LogInButtons';
import LogInButton from 'flarum/forum/components/LogInButton';

app.initializers.add('jiangyuan/oauth2-flarum', () => {
  extend(LogInButtons.prototype, 'items', function(items) {
    const authUrl = app.forum.attribute('jiangyuanAuthUrl') || 'https://auth.dreameriver.cn';
    
    items.add('jiangyuan',
      <LogInButton
        className="Button LogInButton--jiangyuan"
        icon="fas fa-sign-in-alt"
        path={authUrl + '/oauth/authorize'}
      >
        {app.translator.trans('jiangyuan-oauth2-flarum.forum.log_in_with_jiangyuan')}
      </LogInButton>
    );
  });
});