<div id="travelo-login" class="travelo-login-box travelo-box">
    <form method="post" action="{{ url('/')}}/auth/login" id="formLogin">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <input type="text" name="email" class="input-text full-width" placeholder="email address">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="input-text full-width" placeholder="password">
        </div>
        <div class="form-group">
            <button type="submit" class="button full-width">Sign In</button>
        </div>
    </form>
    <div class="seperator"></div>
    <p>Don't have an account? <a href="#travelo-signup" class="goto-signup soap-popupbox">Sign up</a></p>
</div>
