<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="content lifeContent">
        <div class="heading-sponser">
            <h2>Edit Session</h2>
            <a class="btn btn btn-primary" href="{{url('/')}}/update/event/{{$session['event_id']}}">Back</a>


        </div>
        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif


            <?php
                $data = array();

                    for($i = 0; $i < count($session['session_speakers']); $i++){
                        $data[] = $session['session_speakers'][$i]['speaker_id'];
                    }

                ?>
            {{--{{dd($session['session_speakers'][0]['id'])}}--}}

            <form action="{{url('/')}}/update/session/{{$session['event_id'].'/'.$session['id']}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Place</span>
                    <input type=text name="place" value="{{$session['place']}}">
                    @if ($errors->has('place'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('place') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Time</span>
                    {{--<input type=text name="name1" placeholder="9AM - 7PM" value="@if(isset($session['time'])) {{$session['time']}} @endif">--}}
                    @if ($errors->has('name1'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('name1') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                    <input type='hidden' id='time_picker' name='time' placeholder='5AM - 2PM' value="{{$session['time']}}">
                    <?php $time = explode('-',$session['time']) ?>
                    <p><i class="slider-time">{{$time[0]}}</i> - <i class="slider-time2">{{$time[1]}}</i></p>
                    <div class="sliders_step1">
                        <div id="slider-range"></div>
                    </div>
                </label>
                <label class="fullField">
                    <span>Title</span>
                    <input type=text name="title" placeholder="" value="@if(isset($session['title'])) {{$session['title']}} @endif">
                    @if ($errors->has('title1'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('title1') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Speakers</span>
                    <input type=text name="speakers" placeholder="" value="{{$session['speakers']}}">
                    @if ($errors->has('speakers'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('speakers') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Description</span>
                    <textarea name="description" class="wh-speaker">@if(isset($session['description'])){!! $session['description'] !!}@endif</textarea>
                    @if ($errors->has('description'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('description') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif

                </label>
                <label class="fullField">
                    <span>Image</span>
                    <input type=file name="image" value="">
                </label>
                <div class="imgCol">
                    @if($session['image'] != '')
                        <button type="button" class="del-img-btn" data-id="{{$session['id']}}" data-col="image" data-table="sessions">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$session['image']}}" style="width: 100px;"></figure>
                    @endif
                </div>
                <label class="fullField">
                    <span>Speaker</span>
                    <select name="speaker[]" id="public-methods" multiple>
                        @foreach($speakers as $speaker)
                            <option value="{{$speaker->id}}" @if(in_array($speaker->id,$data)) selected @endif>{{$speaker->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('speaker2'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('speaker2') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <input type="hidden" name="speakers_string" id="multiple_value" value="{{','.$string}}"/>
                <div class="btnCol">
                    <input class="btn btn-primary" type="submit" name="signIn"  value="Submit">
                </div>
            </form>
        </div>
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>



<script src="{{ URL::to('src/js/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

<script>
    var editor_config = {
        path_absolute :"{{url('/')}}/",
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscrenn",
            "inserdatetime media  nonbreaking save table contextmenu directonality",
            "emotions template pasts textcolor colorpicker textpattren"
        ],
        toolbar:"insertfile undo redo | stylesheet | bolditalic | alignleft aligncenter alignright alignjustify | bullist | numlist | linkimagemedi | outdent |indenet",
        relative_url: false,
        file_browser_callback: function(field_name,url,type,win)
        {
            var x = window.innerWidth | document.documentElement.ClientWidth | document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight | document.documentElement.ClientHeight | document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absoulte +'laravel-filemanager?field_name'+field
            if(type == 'image')
            {
                cmsURL = cmsURL+"&type=Image";
            }
            else
            {
                cmsURL = cmsURL +"&type=File"
            }
            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title: 'Filemanager',
                width : x*0.8,
                height : y*0.8,
                resizeable : "yes",
                close_previous : "no"
            });
        }

    };
    tinymce.init(editor_config);
</script>




<script>
    $("#datepicker").datepicker({
        altFormat: "yy-mm-dd"
    });



    $(document).ready(function () {
        $('#public-methods').multiSelect({
            afterSelect: function(values){

                var get_val = ""+$("#multiple_value").val();
                //var hidden_val = (get_val != "") ? get_val+"," : get_val;
                var hidden_val = get_val+","+values;
                $("#multiple_value").val(hidden_val);
                //$("#multiple_value").val(hidden_val+""+value);
                //alert("Selecting value: "+values);
                //alert ( "HIDDEN value: "+ hidden_val) ;

            },
            afterDeselect: function(values){

                //alert("Deselect value: "+values);
                var get_val = $("#multiple_value").val();
                var new_val = get_val.replace(","+values, "");
                $("#multiple_value").val(new_val);
                //alert("HIDDEN value after deselecting: "+new_val);
            }
        });

        $('#select-all').click(function(){
            $('#public-methods').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function(){
            $('#public-methods').multiSelect('deselect_all');
            $("#multiple_value").val("");
            //alert ("HERE");
            return false;
        });


        //slider js
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

