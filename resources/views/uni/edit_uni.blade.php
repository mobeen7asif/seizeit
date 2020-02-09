<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="content lifeContent">
        <div class="heading-Sponser">
            <h2>Update Uni</h2>
            <a class="btn btn btn-primary back" href="{{url('/')}}/uni">Back</a>
        </div>
        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif

            <form action="{{url('/')}}/update/uni/{{$uni->id}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Name</span>
                    <input type="text" name="name" value="{{$uni->name}}">
                    @if ($errors->has('name'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('name') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>

                <?php

                function checkSelectedMajor($major_id,$uni_majors) {
                    foreach($uni_majors as $uni_major) {
                        if($uni_major->major_id == $major_id) {
                            return true;
                        }else {
                            return false;
                        }

                    }
                }

                ?>

                {{--<label class="fullField">
                    <span>Select Majors</span>

                    <select class="majors" name="majors[]" multiple="multiple">
                        @foreach($all_majors as $major)
                            <option @if(in_array($major->id,$uni_majors)) selected @endif value="{{$major->id}}">{{$major->name}}</option>
                        @endforeach

                    </select>


                    @if ($errors->has('majors'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('majors') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>--}}
                {{--<label class="fullField">
                    <span>Designation</span>
                    <input type=text name="designation" value="{{$uni->designation}}">
                    @if ($errors->has('designation'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('designation') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>--}}
                <label class="fullField">
                    <span>Uni Detail</span>
                    <textarea name="uni_detail" class="wh-speaker">{!! $uni->uni_detail !!}</textarea>
                    @if ($errors->has('uni_detail'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('uni_detail') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif

                </label>
            {{--    <label class="fullField">
                    <span>Image</span>
                    <input type=file name="image" value="">
                </label>
                <div class="imgCol">
                    @if($uni->image != '')
                        <button type="button" class="del-img-btn" data-id="{{$uni->id}}" data-col="image" data-table="unis">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$uni->image}}" style="width: 100px;"></figure>
                    @endif
                </div>--}}
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
    $(document).ready(function() {
        $('.majors').select2();
    });

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
