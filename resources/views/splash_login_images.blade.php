<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="contentPd">
        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
                <h2 class="mainHEading">Login Splash Images</h2>
            <form action="{{url('/')}}/update/images" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Splash Image</span>
                    <input type=file name="splash_image" value="">
                </label>
                @if ($errors->has('splash_image'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('splash_image') as $message)
                            {{ $message }}<br>
                        @endforeach
                    </div>
                @endif
                <div class="imgCol">
                    @if($image->splash_image != '')
                        <button type="button" class="del-img-btn" data-id="{{$image->id}}" data-col="splash_image" data-table="images">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$image->splash_image}}" style="width: 100px;"></figure>
                    @endif
                </div>
                <label class="fullField">
                    <span>Login Image</span>
                    <input type=file name="login_image" value="">
                </label>
                @if ($errors->has('login_image'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('login_image') as $message)
                            {{ $message }}<br>
                        @endforeach
                    </div>
                @endif
                <div class="imgCol">
                    @if($image->login_image != '')
                        <button type="button" class="del-img-btn" data-id="{{$image->id}}" data-col="login_image" data-table="images">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$image->login_image}}" style="width: 100px;"></figure>
                    @endif
                </div>
                <label class="fullField">
                    <span>Navigation Image</span>
                    <input type=file name="navigation_image" value="">
                </label>
                @if ($errors->has('navigation_image'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('navigation_image') as $message)
                            {{ $message }}<br>
                        @endforeach
                    </div>
                @endif
                <div class="imgCol">
                    @if($image->navigation_image != '')
                        <button type="button" class="del-img-btn" data-id="{{$image->id}}" data-col="navigation_image" data-table="images">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$image->navigation_image}}" style="width: 100px;"></figure>
                    @endif
                </div>
                <div class="btnCol">
                    <input type="submit" name="signIn"  value="Submit">
                </div>
            </form>
        </div>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>



