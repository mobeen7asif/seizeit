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
    <a class="btn btn-primary add_s" href="{{url('/')}}/add/event">Add New Event</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Events</h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Place</th>
                <th>Date</th>
                <th>Actions</th>
                <th>Sessions</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($events))
                @foreach($events as $event)
                    <tr>
                        <td>{{$event['place']}}</td>
                        <td>{{$event['date']}}</td>
                        <td>
                            <a href={{url('/')}}/update/event/{{$event->id}}><i class="fa fa-edit fa-fw"></i></a>
                            <form class="actioN" method="post" action="{{url('/')}}/delete/event/{{$event->id}}">{{csrf_field()}}<button><i class="fa fa-trash fa-fw"></i></button></form>
                        </td>
                        <td><a href="{{url('/')}}/view/sessions/{{$event->id}}">Sessions</a></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>


