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
        <a class="btn btn btn-primary back" href="{{url('/')}}/categories">Back</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Category  Detail</h2>
        {{--{{dd($session)}}--}}
        <span><b>Name</b></span>
        <P>{{$category->name}}</P>
        <br>
        <span><b>URL</b></span>
        <P>{{$category->url}}</P>
        <br>
        <span><b>Description</b></span>
        <p>{!! $category->description !!}</p>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
