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
        <a class="btn btn btn-primary" href="{{url('/')}}/activities">Back</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Activity Detail</h2>
        {{--{{dd($session)}}--}}
        <span><b>Name</b></span>
        <P>{{$activity->name}}</P>
        <br>
        <span><b>Description</b></span>
        <P>{!! $activity->description !!}</P>
        <br>
        <span><b>Image</b></span>
        <figure class="cars"><img src="{{url('/').$activity->image}}" style="width: 100px"></figure>
        <br>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
