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
        <a class="back" href="{{url('/')}}/update/event/{{$session['event_id']}}">Back</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Session Detail</h2>
        {{--{{dd($session)}}--}}
        <span><b>Place</b></span>
        <P>{{$session['place']}}</P>
        <br>
        <span><b>Time</b></span>
        <P>{{$session['time']}}</P>
        <br>
        <span><b>Title</b></span>
        <p>{{$session['title']}}</p>
        <br>
        <span><b>Speakers Text</b></span>
        <p>{{$session['uni']}}</p>
        <br>
        <span><b>Description</b></span>
        <P>{!! $session['description'] !!}</P><br>
        <span><b>Session Image</b></span>
        @if($session['image'] != '') <figure> <img src="{{url('/').$session['image']}}" style="width: 100px"></figure> @endif
        <br>
        <?php
        foreach($session['session_speakers'] as $speaker){
            $data = \App\Uni::find($speaker['speaker_id']);?>
        <span><b>Speaker Detail</b></span>
        <br>
        @if($data['image'] != '') <figure><img src="{{url('/').$data['image']}}" style="width: 100px"></figure> @endif
        <br>

        <span><b>Name</b></span>
        <P>{{$data['name']}}</P>
        <br>
        <span><b>Designation</b></span>
        <p>{{$data['designation']}}</p>


        <?php }

        ?>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
