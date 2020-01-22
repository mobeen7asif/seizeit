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
        <a class="add_s" href="{{url('/')}}/add/event">Add New Event</a>

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
        <form method="post" action="{{url('/')}}/event/bulk/delete">
            {{csrf_field()}}
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Date</th>
                <th>Sessions</th>
                <th>Actions</th>
                <th>@if(!$events->isEmpty()) <input class="submit" id="bulk_button"  type="submit" value="Delete" > @endif</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($events))
                @foreach($events as $event)
                    <tr>
                        <td>{{$event['date']}}</td>
                        <td>
                            <a href="{{url('/')}}/update/event/{{$event->id}}">{{$event->session_text}}</a>
                            {{--<a href="#" class="session_text" data-id="{{$event->id}}" data-text="{{$event->session_text}}"><i class="fa fa-edit fa-fw"></i></a>--}}
                        </td>
                        <td>
                            <a href="{{url('/')}}/update/event/{{$event->id}}"><i class="fa fa-edit fa-fw"></i></a>
                            <a href="{{url('/')}}/delete/event/{{$event->id}}"><i class="fa fa-trash fa-fw "></i></a>
                        </td>
                        <td><input class="delete_check" type="checkbox" value="{{$event->id}}" name="delete_ids[]"></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        </form>
        @if(!$events->isEmpty()) <p><label><input type="checkbox" id="checkAll"/> Check all</label></p> @endif
        <form method="post" action="{{url('/')}}/change/session_text">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change Text</h4>
                    </div>
                    <div class="modal-body">
                        <input class="event_id" name="event_id" type="hidden" value="">
                        <input class="event_text" name="event_text" type="text" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Save</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>

<script>
    $(".session_text").click(function(){
        var id = $(this).attr('data-id');
        var text = $(this).attr('data-text');
        var model = $("#myModal").modal();
        $('.event_id').val(id);
        $('.event_text').val(text);

    });
</script>
