<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>

<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content lifeContent">

    @if(\Session::has('success'))
        <h4 class="alert alert-success fade in">
            {{\Session::get('success')}}
        </h4>
    @endif
        <a class="back" href="{{url('/')}}/sponsors">Back</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Sponsor  Detail</h2>
        {{--{{dd($session)}}--}}
        <span><b>Name</b></span>
        <P>{{$sponsor->name}}</P>
        <br>
        <span><b>Description</b></span>
        <p>{!! $sponsor->description !!}</p>
        <br>
        <span><b>Image</b></span>
        @if(isset($sponsor->image)) <figure class="cars"> <img src="{{url('/').$sponsor->image}}" style="width: 100px"></figure> @endif
        <br>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>