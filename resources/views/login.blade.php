<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<section class="content publicContent loginPage no-top-padding">
    <div class="contentPd">
    <div class="form-area">
    <div class="form-holder">
        <div class="userForm">
            <?php if(Session::has('error')){ ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                <?php echo Session::get('error') ?>
            </div>
            <?php } ?>
            <form action="{{url('/')}}/login" method="post" id="loginform">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Email</span>
                    <input type="text" name="email" value="{{old('email')}}">
                </label>
                <label class="fullField">
                    <span>Password</span>
                    <input type=password name="password" value="">
                </label>
                <div class="btnCol">
                    <input type="submit" name="signIn"  value="Login">
                </div>
            </form>
            <a href="{{url('/')}}/forgot/password">Forgot Password</a>
        </div>
        </div>
        </div>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
