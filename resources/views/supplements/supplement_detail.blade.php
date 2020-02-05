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
        <a class="btn btn btn-primary" href="{{url('/')}}/supplements">Back</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Supplement Detail</h2>
        {{--{{dd($session)}}--}}
        <span><b>Name</b></span>
        <P>{{$supplement->name}}</P>
        <br>
        <span><b>Description</b></span>
        <p>{!! $supplement->detail !!}</p>
        <br>
        <span><b>File</b></span>
        @if(isset($supplement->pdf_file))
            <span>File</span>
            <a href="{{url('/').$supplement->pdf_file}}" target="_blank">{{$supplement->name}}</a>
        @endif
        <br>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
