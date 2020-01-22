<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="content lifeContent">
        <div class="heading-sponser">
        <h2>Add Uni</h2>
            <a class="back" href="{{url('/')}}/uni">Back</a>


        </div>
        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif

            <form action="{{url('/')}}/add/uni" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Name</span>
                    <input type="text" name="name" value="{{old('name')}}">
                    @if ($errors->has('name'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('name') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                {{--<label class="fullField">
                    <span>Designation</span>
                    <input type=text name="designation" value="{{old('designation')}}">
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
                    <textarea name="uni_detail" class="wh-speaker">{!! old('uni_detail') !!}</textarea>
                    @if ($errors->has('uni_detail'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('uni_detail') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif

                </label>
               {{-- <label class="fullField">
                    <span>Image</span>
                    <input type=file name="image" value="">
                </label>--}}
                <div class="btnCol">
                    <input type="submit" name="signIn"  value="Submit">
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
