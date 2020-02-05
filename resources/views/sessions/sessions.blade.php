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
        <a class="add_btn add_s" href="{{url('/')}}/create/session/{{$event_id}}">Add New Session</a>
        <a class="add_btn add_s" href="{{url('/')}}/events">Back To Events</a>
    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Sessions</h2>
        @if ($errors->has('delete_ids'))
            <div class="alert alert-danger">
                @foreach ($errors->get('delete_ids') as $message)
                    {{ $message }}<br>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{url('/')}}/session/bulk/delete">
            {{csrf_field()}}
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Time</th>
                <th>Title</th>
                <th>View Detail</th>
                <th>Actions</th>
                <th>@if(!$sessions->isEmpty()) <input class="btn btn-primary submit" id="bulk_button"  type="submit" value="Delete" > @endif</th>

            </tr>
            </thead>
            <tbody>
            @if(isset($sessions))
                @foreach($sessions as $session)
                    <tr>
                        <td>{{$session['time']}}</td>
                        <td>{{$session['title']}}</td>
                        <td><a href="{{url('/')}}/session/detail/{{$session->id}}">Detail</a></td>
                        <td>
                            <a href={{url('/')}}/update/session/{{$session->id}}><i class="fa fa-edit fa-fw"></i></a>
                            <a href={{url('/')}}/delete/session/{{$session->id}}><i class="fa fa-trash fa-fw "></i></a>
                        </td>
                        <td><input class="delete_check" type="checkbox" value="{{$session->id}}" name="delete_ids[]"></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        </form>
        @if(!$sessions->isEmpty()) <p><label><input type="checkbox" id="checkAll"/> Check all</label></p> @endif
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>


