import { extend } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import LogInButtons from 'flarum/forum/components/LogInButtons';
import LogInButton from 'flarum/forum/components/LogInButton';
import SignUpModal from 'flarum/forum/components/SignUpModal';

app.initializers.add('dreamerivercn/oauth2-flarum', () => {
  extend(LogInButtons.prototype, 'items', function(items) {
    const authUrl = app.forum.attribute('dreamerivercnAuthUrl') || 'https://auth.dreameriver.cn';
    
    items.add('dreamerivercn',
      <LogInButton
        className="Button LogInButton--dreamerivercn"
        icon="fas fa-sign-in-alt"
        path={app.route('auth.dreamerivercn')}
      >
        {app.translator.trans('dreamerivercn-oauth2-flarum.forum.log_in_with_dreamerivercn')}
      </LogInButton>
    );
  });

  extend(SignUpModal.prototype, 'footer', function(vnode) {
    const authUrl = app.forum.attribute('dreamerivercnAuthUrl') || 'https://auth.dreameriver.cn';
    
    vnode.children.push(
      <div className="Form-group">
        <hr/>
        <p className="helpText">{app.translator.trans('dreamerivercn-oauth2-flarum.forum.sign_up_with_dreamerivercn')}</p>
        <a className="Button LogInButton--dreamerivercn" href={app.route('register.dreamerivercn')}>
          {app.translator.trans('dreamerivercn-oauth2-flarum.forum.sign_up_with_dreamerivercn')}
        </a>
      </div>
    );
  });
});