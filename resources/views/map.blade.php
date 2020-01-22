<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent loginPage no-top-padding">
    <div class="contentPd">
    <div class="form-area">
    <div class="form-holder">

        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
            <form action="{{url('/')}}/update/map" method="post" id="loginform" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Map Image</span>
                    <input type="file" name="map" value="">
                </label>
                @if ($errors->has('map'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('map') as $message)
                            {{ $message }}<br>
                        @endforeach
                    </div>
                @endif
                <div class="imgCol">
                    @if($map->map != '')
                        <button type="button" class="del-img-btn" data-id="{{$map->id}}" data-col="map" data-table="welcome">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$map->map}}" style="width: 200px;"></figure>
                    @endif
                </div>
                {{--<img src="{{url('/').$map}}" style="width: 200px">--}}
                <br>
                <br>
                <div class="btnCol">
                    <input type="submit" name="signIn"  value="Submit">
                </div>
            </form>
        </div>
        </div>
        </div>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
