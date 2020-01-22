<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">
    <div class="content lifeContent">
        <div class="heading-sponser">
        <h2>Edit Sponser</h2>
            <a class="back" href="{{url('/')}}/sponsors">Back</a>
    </div>
        <div class="userForm">
            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
            <form action="{{url('/')}}/update/sponsor/{{$sponsor->id}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span>Name/Description</span>
                    <input type="text" name="name" value="{{$sponsor->name}}">
                    @if ($errors->has('name'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('name') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Detail</span>
                    <div class="inputs"><textarea name="description">{!! $sponsor->description !!}</textarea></div>
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
                    @if($sponsor->image != '')
                        <button type="button" class="del-img-btn" data-id="{{$sponsor->id}}" data-col="image" data-table="sponsors">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$sponsor->image}}" style="width: 100px;"></figure>
                    @endif
                </div>
                <label class="fullField">
                    <span>Signature Image</span>
                    <input type=file name="signature_image" value="">
                </label>
                <div class="imgCol">
                    @if($sponsor->signature_image != '')
                        <button type="button" class="del-img-btn" data-id="{{$sponsor->id}}" data-col="signature_image" data-table="sponsors">
                            <i class="fa fa-trash"></i>
                        </button>
                        <figure class="car"><img src="{{url('/').$sponsor->signature_image}}" style="width: 100px;"></figure>
                    @endif
                </div>
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
