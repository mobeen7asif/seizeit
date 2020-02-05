<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<section class="content publicContent loginPage no-top-padding bg_image">
    <div class="contentPd">
    <div class="form-area">
    <div class="form-holder">
        <div class="userForm">
            <div style="text-align: center">
                <label style="font-size: 33px;font-weight: bold">SeizeIT</label>
            </div>
            <?php if(Session::has('error')){ ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                <?php echo Session::get('error') ?>
            </div>
            <?php } ?>
            <form action="{{url('/')}}/login" method="post" id="loginform">
                {{csrf_field()}}
                <label class="fullField">
                    <span class="login_span">Email</span>
                    <input type="text" name="email" value="{{old('email')}}">
                </label>
                <label class="fullField">
                    <span class="login_span">Password</span>
                    <input type=password name="password" value="">
                </label>
                <label class="fullField">
                    <input class="btn btn-primary" type="submit" name="signIn"  value="Login">
                </label>
            </form>
            {{--<a href="{{url('/')}}/forgot/password">Forgot Password</a>--}}
        </div>
        </div>
        </div>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
