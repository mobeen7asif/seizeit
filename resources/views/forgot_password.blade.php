<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<section class="content publicContent loginPage">
    @if(\Session::has('success'))
        <h4 class="alert alert-success fade in">
            {{\Session::get('success')}}
        </h4>
    @endif
        @if(\Session::has('error'))
            <h4 class="alert alert-danger fade in">
                {{\Session::get('error')}}
            </h4>
        @endif
    <div class="contentPd">
        <div class="userForm">
            <form action="{{url('/')}}/send/mail_link" method="post" id="loginform">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Email</span>
                    <input type="text" name="email" value="">
                </label>
                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('email') as $message)
                            {{ $message }}<br>
                        @endforeach
                    </div>
                @endif
                <div class="btnCol">
                    <a class="add_btn" href="{{url('/')}}/login">Back</a>
                    <input  type="submit" name="signIn"  value="Submit">
                </div>
            </form>
        </div>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
