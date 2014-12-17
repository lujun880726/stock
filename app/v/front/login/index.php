<div class="container">
    <form class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="" class="form-control" placeholder="账号" name="account" required autofocus>
        <input type="password" class="form-control" name="pwd" placeholder="密码" required>
        <div class="checkbox">
            <label>
<!--            <input type="checkbox" value="remember-me"> Remember me--><code><?PHP if (isset($err) && $err) ECHO $err ?></code>
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div> <!-- /container -->