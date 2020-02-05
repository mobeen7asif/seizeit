<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="content lifeContent">
        <div class="heading-sponser">
        <h2>Update Event</h2>
            <a class="btn btn btn-primary" href="{{url('/')}}/events">Back</a>
    </div>


        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
            <form action="{{url('/')}}/update/event/{{$event->id}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Event Date</span>
                    <input type="text" name="date" id="datepicker" value="{{$event->date}}">
                    @if ($errors->has('date'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('date') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Session Text</span>
                    <input type=text name="session_text" value="{{$event->session_text}}">
                    @if ($errors->has('session_text'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('session_text') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <div class="btnCol">
                    <input class="btn btn-primary" type="submit" name="signIn"  value="Submit">
                </div>
            </form>
        </div>
        <a class="add_btn add_s" href="{{url('/')}}/create/session/{{$event->id}}">Add New Session</a>
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
<script>
    $("#datepicker").datepicker({
        altFormat: "yy-mm-dd"
    });
</script>
