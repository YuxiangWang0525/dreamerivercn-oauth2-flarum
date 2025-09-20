<div class="container">
    <h2>Dreameriver.cn OAuth2 设置</h2>
    
    <p>在此配置您的Dreameriver.cn OAuth2认证设置。</p>
    
    <form method="POST" action="{{ $this->app->url() }}">
        <div class="Form-group">
            <label>客户端ID</label>
            <input type="text" name="dreamerivercn-oauth.client_id" value="{{ $settings->get('dreamerivercn-oauth.client_id') }}" class="form-control">
            <p class="help-block">在Dreameriver.cn通行证创建应用时获得的客户端ID。</p>
        </div>
        
        <div class="Form-group">
            <label>客户端密钥</label>
            <input type="password" name="dreamerivercn-oauth.client_secret" value="{{ $settings->get('dreamerivercn-oauth.client_secret') }}" class="form-control">
            <p class="help-block">在Dreameriver.cn通行证创建应用时获得的客户端密钥。</p>
        </div>
        
        <div class="Form-group">
            <label>认证URL</label>
            <input type="text" name="dreamerivercn-oauth.auth_url" value="{{ $settings->get('dreamerivercn-oauth.auth_url', 'https://auth.dreameriver.cn') }}" class="form-control">
            <p class="help-block">Dreameriver.cn通行证认证的基础URL（通常不需要更改）。</p>
        </div>
        
        <button type="submit" class="btn btn-primary">保存设置</button>
    </form>
</div>