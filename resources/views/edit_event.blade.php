<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="content lifeContent">
        <div class="heading-sponser">
        <h2>Add Event</h2>
            <a class="back" href="{{url('/')}}/events">Back</a>
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
                    <span>Place</span>
                    <input type=text name="place" value="{{$event->place}}">
                    @if ($errors->has('place'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('place') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                {{--<label class="fullField">--}}
                    {{--<span>Time1</span>--}}
                    {{--<input type=text name="name1" placeholder="9AM - 7PM" value="{{old('name1')}}">--}}
                    {{--@if ($errors->has('name1'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--@foreach ($errors->get('name1') as $message)--}}
                                {{--{{ $message }}<br>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    {{--<input type='hidden' id='time_picker' name='time' placeholder='5AM - 2PM' value="{{old('hours_of_operation')}}">--}}
                    {{--<p><i class="slider-time">05:00 AM</i> - <i class="slider-time2">02:00 PM</i></p>--}}
                    {{--<div class="sliders_step1">--}}
                        {{--<div id="slider-range"></div>--}}
                    {{--</div>--}}
                {{--</label>--}}
                {{--<label class="fullField">--}}
                    {{--<span>Title</span>--}}
                    {{--<input type=text name="title" placeholder="" value="{{old('title1')}}">--}}
                    {{--@if ($errors->has('title1'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--@foreach ($errors->get('title1') as $message)--}}
                                {{--{{ $message }}<br>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</label>--}}
                {{--<label class="fullField">--}}
                    {{--<span>Time2</span>--}}
                    {{--<input type="hidden" id="time_picker1" name="time2" placeholder="5AM - 2PM" value="{{old('happy_hours')}}">--}}
                    {{--<p><i class="slider-times">05:00 AM</i> - <i class="slider-times2">02:00 PM</i></p>--}}
                    {{--<div class="sliders_step">--}}
                        {{--<div id="slider-range1"></div>--}}
                    {{--</div>--}}
                    {{--@if ($errors->has('time2'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--@foreach ($errors->get('time2') as $message)--}}
                                {{--{{ $message }}<br>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</label>--}}
                {{--<label class="fullField">--}}
                    {{--<span>Title2</span>--}}
                    {{--<input type=text name="title2" placeholder="" value="{{old('title2')}}">--}}
                    {{--@if ($errors->has('title2'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--@foreach ($errors->get('title2') as $message)--}}
                                {{--{{ $message }}<br>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</label>--}}
                {{--<label class="fullField">--}}
                    {{--<span>Uni</span>--}}
                    {{--<select name="speaker1" id="area">--}}
                        {{--@foreach($speakers as $speaker)--}}
                        {{--<option value="{{$speaker->id}}">{{$speaker->name}}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                    {{--@if ($errors->has('speaker1'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--@foreach ($errors->get('speaker1') as $message)--}}
                                {{--{{ $message }}<br>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</label>--}}
                {{--<h2>Section 3</h2>--}}
                {{--<label class="fullField">--}}
                    {{--<span>Title3</span>--}}
                    {{--<input type=text name="title3" placeholder="" value="{{old('title3')}}">--}}
                    {{--@if ($errors->has('title3'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--@foreach ($errors->get('title3') as $message)--}}
                                {{--{{ $message }}<br>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</label>--}}
                {{--<label class="fullField">--}}
                    {{--<span>Time3</span>--}}
                    {{--<input type='hidden' id='time_picker3' name='time3' placeholder='5AM - 2PM' value="{{old('hours_of_operation')}}">--}}
                    {{--<p><i class="slider-times3">05:00 AM</i> - <i class="slider-time3">02:00 PM</i></p>--}}
                    {{--<div class="sliders_step3">--}}
                        {{--<div id="slider-range3"></div>--}}
                    {{--</div>--}}
                    {{--@if ($errors->has('time2'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--@foreach ($errors->get('time3') as $message)--}}
                                {{--{{ $message }}<br>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</label>--}}
                {{--<label class="fullField">--}}
                    {{--<span>Description</span>--}}
                    {{--<textarea name="uni_detail">{{old('description')}}</textarea>--}}
                    {{--@if ($errors->has('uni_detail'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--@foreach ($errors->get('uni_detail') as $message)--}}
                                {{--{{ $message }}<br>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--@endif--}}

                {{--</label>--}}
                {{--<label class="fullField">--}}
                    {{--<span>Image</span>--}}
                    {{--<input type=file name="image" value="">--}}
                {{--</label>--}}
                {{--<label class="fullField">--}}
                    {{--<span>Uni</span>--}}
                    {{--<select name="speaker[]" id="area" multiple>--}}
                        {{--@foreach($speakers as $speaker)--}}
                            {{--<option value="{{$speaker->id}}">{{$speaker->name}}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                    {{--@if ($errors->has('speaker2'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--@foreach ($errors->get('speaker2') as $message)--}}
                                {{--{{ $message }}<br>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</label>--}}
                <div class="btnCol">
                    <input type="submit" name="signIn"  value="Submit">
                </div>
            </form>
        </div>
    </div>
</section>
<script src="{{url('/')}}/js/jquery.min.js"></script>
<script src="{{url('/')}}/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/js/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/mian.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
</script>


<script>
    $("#datepicker").datepicker({
        altFormat: "yy-mm-dd"
    });



    $(document).ready(function () {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('header button').click(function () {
            $('aside').toggleClass('custom-menu');
            $('main').toggleClass('main-margin');
        });
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 1440,
            step: 15,
            values: [600, 720],
            slide: function (e, ui) {
                var hours1 = Math.floor(ui.values[0] / 60);
                var minutes1 = ui.values[0] - (hours1 * 60);

                if (hours1.length == 1) hours1 = '0' + hours1;
                if (minutes1.length == 1) minutes1 = '0' + minutes1;
                if (minutes1 == 0) minutes1 = '00';
                if (hours1 >= 12) {
                    if (hours1 == 12) {
                        hours1 = hours1;
                        minutes1 = minutes1 + " PM";
                    } else {
                        hours1 = hours1 - 12;
                        minutes1 = minutes1 + " PM";
                    }
                } else {
                    hours1 = hours1;
                    minutes1 = minutes1 + " AM";
                }
                if (hours1 == 0) {
                    hours1 = 12;
                    minutes1 = minutes1;
                }



                $('.slider-time').html(hours1 + ':' + minutes1);

                var hours2 = Math.floor(ui.values[1] / 60);
                var minutes2 = ui.values[1] - (hours2 * 60);

                if (hours2.length == 1) hours2 = '0' + hours2;
                if (minutes2.length == 1) minutes2 = '0' + minutes2;
                if (minutes2 == 0) minutes2 = '00';
                if (hours2 >= 12) {
                    if (hours2 == 12) {
                        hours2 = hours2;
                        minutes2 = minutes2 + " PM";
                    } else if (hours2 == 24) {
                        hours2 = 11;
                        minutes2 = "59 PM";
                    } else {
                        hours2 = hours2 - 12;
                        minutes2 = minutes2 + " PM";
                    }
                } else {
                    hours2 = hours2;
                    minutes2 = minutes2 + " AM";
                }

                $('.slider-time2').html(hours2 + ':' + minutes2);
                $('#time_picker').val(hours1 + ':' + minutes1+ - +hours2 + ':' + minutes2);
            }
        });
        $("#slider-range1").slider({
            range: true,
            min: 0,
            max: 1440,
            step: 15,
            values: [600, 720],
            slide: function (e, ui) {
                var hours1 = Math.floor(ui.values[0] / 60);
                var minutes1 = ui.values[0] - (hours1 * 60);

                if (hours1.length == 1) hours1 = '0' + hours1;
                if (minutes1.length == 1) minutes1 = '0' + minutes1;
                if (minutes1 == 0) minutes1 = '00';
                if (hours1 >= 12) {
                    if (hours1 == 12) {
                        hours1 = hours1;
                        minutes1 = minutes1 + " PM";
                    } else {
                        hours1 = hours1 - 12;
                        minutes1 = minutes1 + " PM";
                    }
                } else {
                    hours1 = hours1;
                    minutes1 = minutes1 + " AM";
                }
                if (hours1 == 0) {
                    hours1 = 12;
                    minutes1 = minutes1;
                }



                $('.slider-times').html(hours1 + ':' + minutes1);

                var hours2 = Math.floor(ui.values[1] / 60);
                var minutes2 = ui.values[1] - (hours2 * 60);

                if (hours2.length == 1) hours2 = '0' + hours2;
                if (minutes2.length == 1) minutes2 = '0' + minutes2;
                if (minutes2 == 0) minutes2 = '00';
                if (hours2 >= 12) {
                    if (hours2 == 12) {
                        hours2 = hours2;
                        minutes2 = minutes2 + " PM";
                    } else if (hours2 == 24) {
                        hours2 = 11;
                        minutes2 = "59 PM";
                    } else {
                        hours2 = hours2 - 12;
                        minutes2 = minutes2 + " PM";
                    }
                } else {
                    hours2 = hours2;
                    minutes2 = minutes2 + " AM";
                }

                $('.slider-times2').html(hours2 + ':' + minutes2);
                $('#time_picker1').val(hours1 + ':' + minutes1+ - +hours2 + ':' + minutes2);
            }
        });

        $("#slider-range3").slider({
            range: true,
            min: 0,
            max: 1440,
            step: 15,
            values: [600, 720],
            slide: function (e, ui) {
                var hours1 = Math.floor(ui.values[0] / 60);
                var minutes1 = ui.values[0] - (hours1 * 60);

                if (hours1.length == 1) hours1 = '0' + hours1;
                if (minutes1.length == 1) minutes1 = '0' + minutes1;
                if (minutes1 == 0) minutes1 = '00';
                if (hours1 >= 12) {
                    if (hours1 == 12) {
                        hours1 = hours1;
                        minutes1 = minutes1 + " PM";
                    } else {
                        hours1 = hours1 - 12;
                        minutes1 = minutes1 + " PM";
                    }
                } else {
                    hours1 = hours1;
                    minutes1 = minutes1 + " AM";
                }
                if (hours1 == 0) {
                    hours1 = 12;
                    minutes1 = minutes1;
                }



                $('.slider-times3').html(hours1 + ':' + minutes1);

                var hours2 = Math.floor(ui.values[1] / 60);
                var minutes2 = ui.values[1] - (hours2 * 60);

                if (hours2.length == 1) hours2 = '0' + hours2;
                if (minutes2.length == 1) minutes2 = '0' + minutes2;
                if (minutes2 == 0) minutes2 = '00';
                if (hours2 >= 12) {
                    if (hours2 == 12) {
                        hours2 = hours2;
                        minutes2 = minutes2 + " PM";
                    } else if (hours2 == 24) {
                        hours2 = 11;
                        minutes2 = "59 PM";
                    } else {
                        hours2 = hours2 - 12;
                        minutes2 = minutes2 + " PM";
                    }
                } else {
                    hours2 = hours2;
                    minutes2 = minutes2 + " AM";
                }

                $('.slider-time3').html(hours2 + ':' + minutes2);
                $('#time_picker3').val(hours1 + ':' + minutes1+ - +hours2 + ':' + minutes2);
            }
        });
    });
</script>
</Body>
</html>
