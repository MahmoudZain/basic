<div class="container">
    <h2><?php _e('Registration form', 'default'); ?></h2>

    <form id="register" class="form-horizontal" role="form" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name"><?php _e('Name', 'default'); ?>:</label>

            <div class="col-sm-4">
                <input type="text" class="form-control" id="name" placeholder="Enter Your Name"
                       name="user_name" data-validation="required">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email"><?php _e('Email', 'default'); ?>:</label>

            <div class="col-sm-4">
                <input type="email" class="form-control" id="email" placeholder="Enter Your E-mail"
                       name="email" data-validation="email server" data-validation-url="/ajax-handler/">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd"><?php _e('Password', 'default'); ?>:</label>

            <div class="col-sm-4">
                <input type="password" class="form-control" id="pass" placeholder="Enter Password"
                       name="password_confirmation" data-validation="length alphanumeric required"
                       data-validation-length="min6">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Re-Password:</label>

            <div class="col-sm-4">
                <input type="password" class="form-control" id="re-password" placeholder="Re-Enter Password"
                       name="password" data-validation="confirmation required">
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
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $.validate({
        modules: 'security'
    });
</script>