<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="content lifeContent">
        <div class="heading-sponser">
            <h2>Update User</h2>
            <a class="btn btn btn-primary back" href="{{url('/')}}/admins">Back</a>
        </div>
        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
            <form action="{{url('/')}}/update/user/{{$user->id}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span>First Name</span>
                    <input type="text" name="first_name" value="{{$user->first_name}}">
                    @if ($errors->has('first_name'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('first_name') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Last Name</span>
                    <input type="text" name="last_name" value="{{$user->last_name}}">
                    @if ($errors->has('last_name'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('last_name') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Phone</span>
                    <input type="text" name="phone" value="{{$user->phone}}">
                    @if ($errors->has('phone'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('phone') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>User Email</span>
                    <input type="text" name="email" value="{{$user->email}}">
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('email') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>User Name</span>
                    <input type="text" name="user_name" value="{{$user->user_name}}">
                    @if ($errors->has('user_name'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('user_name') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Password</span>
                    <input type=text name="password">
                    @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('password') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <div class="btnCol">
                    <input class="btn btn-primary" type="submit" name="signIn"  value="Submit">
                </div>
            </form>
        </div>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
