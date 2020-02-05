<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<section class="content publicContent loginPage no-top-padding">
    <div class="contentPd">
        <div class="form-area">
            <div class="form-holder">
                <div class="userForm">
                    <h3>Enter New Password</h3>
                    <form method="post" action="{{url('/')}}/reset_password">
                        {{csrf_field()}}
                        @if ($errors->has('password'))
                            <div class="alert alert-danger">
                                @foreach ($errors->get('password') as $message)
                                    {{ $message }}<br>
                                @endforeach
                            </div>
                        @endif
                        <label class="fullField">
                            <span>Password</span>
                            <input type="password" name="password">
                        </label>
                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="token" value="{{$token}}">
                        <div class="btnCol">
                            <input class="btn btn-primary" type="submit" name="signIn"  value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
