<div class="container">
    <h2 class="form-signin-heading">Please sign in</h2>

    <div id="error-message-wrapper"></div>
    <form id="register" class="form-horizontal" role="form" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Email:</label>

            <div class="col-sm-4">
                <input type="email" class="form-control" id="email" placeholder="Enter Your E-mail"
                       name="email" data-validation="email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Password:</label>

            <div class="col-sm-4">
                <input type="password" class="form-control" id="pass" placeholder="Enter Password"
                       name="password" data-validation="required">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label><input name="remember" type="checkbox">Remember me</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </div>
        </div>
    </form>
    <?php if ($_GET['err']) { ?>
        <div class="form-error alert alert-danger"><strong>Login failed</strong></div>
    <?php } else { ?>
        <div class="form-error alert alert-danger hidden"><strong>Login failed</strong></div>
    <?php } ?>

</div>
<script type="text/javascript">
    var $messages = $('#error-message-wrapper');
    $.validate({
        validateOnBlur: false,
        errorMessagePosition: 'top',
        modules: 'security'
    });
    $(document).on('focusin', '#email', function () {
        $('.alert-danger').addClass('hidden');
    });
</script>