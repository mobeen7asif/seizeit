<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="contentPd">
        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
            <form action="{{url('/')}}/update/welcome/content" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span class="text"><b>Name</b></span>
                    <div class="inputs"><textarea name="name">{!! $content->name !!}</textarea></div>
                    @if ($errors->has('name'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('name') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span class="text">Detail</span>
                    <textarea name="description">@if(isset($content->description)){!! $content->description !!}@endif</textarea>
                    @if ($errors->has('description'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('description') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif

                </label>
                <label class="fullField">
                    <span class="text"><b>Image</b></span>
                        <div class="fullfield-cont man">
                            <span><input type=file name="image" value=""></span>
                        </div>
                </label>
                <div class="imgCol">
                    @if($content['image'] != '')
                        <button type="button" class="del-img-btn" data-id="{{$content['id']}}" data-col="image" data-table="welcome">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$content['image']}}" style="width: 100px;"></figure>
                    @endif
                </div>
                <label class="fullField">
                    <span class="text"><b>Signature Image</b></span>
                    <div class="fullfield-cont">
                        <span><input type=file name="signature_image" value=""></span>
                    </div>
                </label>
                <div class="imgCol">
                    @if($content['signature'] != '')
                        <button type="button" class="del-img-btn" data-id="{{$content['id']}}" data-col="signature" data-table="welcome">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$content['signature']}}" style="width: 100px;"></figure>
                    @endif
                </div>
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

