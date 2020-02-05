<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="content lifeContent">
        <div class="heading-sponser">
            <h2>Add Event</h2>
            <a class="btn btn btn-primary" href="{{url('/')}}/events">Back</a>
        </div>
        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
            <form action="{{url('/')}}/add/event" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Event Date</span>
                    <input type="text" name="date" id="datepicker" value="{{old('date')}}">
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
                    <input type=text name="session_text" value="">
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
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>
<script>
    $("#datepicker").datepicker({
        altFormat: "yy-mm-dd"
    });

</script>
