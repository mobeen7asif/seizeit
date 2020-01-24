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
        <a class="back" href="{{url('/')}}/majors">Back</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Major  Detail</h2>
        {{--{{dd($session)}}--}}
        <span><b>Name</b></span>
        <P>{{$major->name}}</P>
        <br>
        <span><b>Description</b></span>
        <p>{!! $major->description !!}</p>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
