<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">

    <div class="content lifeContent">
        <div class="heading-sponser">
            <h2>Add Sub Category</h2>
            <a class="btn btn btn-primary back" href="{{url('/')}}/sub/categories">Back</a>
        </div>
        <div class="userForm user">

            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
                @if(\Session::has('error'))
                    <h4 class="alert alert-error fade in">
                        {{\Session::get('error')}}
                    </h4>
                @endif
            <form action="{{url('/')}}/add/custom/category" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="fullField">
                    <span class="required">Select Uni</span>
                    <select class="unis" name="uni_id[]" multiple required>
                        @foreach($unis as $uni)
                            <option value="{{$uni->id}}">{{$uni->name}}</option>
                        @endforeach

                    </select>
                    @if ($errors->has('uni_id'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('uni_id') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>

                <label class="fullField">
                    <span>Select Major</span>
                    <select class="majors" name="major_id[]" multiple>
                        @foreach($majors as $major)
                            <option @if(request()->route()->parameter('major_id') == $major->id) selected @endif value="{{$major->id}}">{{$major->name}}</option>
                        @endforeach

                    </select>
                    @if ($errors->has('major_id'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('major_id') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>

                <label class="fullField">
                    <span class="required">Select Category</span>
                    <select id="major_categories" class="categories" multiple required name="category_id[]">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('category_id') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>

                <label class="fullField">
                    <span>Title</span>
                    <input type="text" name="title" value="{{old('title')}}">
                    @if ($errors->has('title'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('title') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Email</span>
                    <input type="text" name="email" value="{{old('email')}}">
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('email') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Address</span>
                    <input type="text" name="address" value="{{old('address')}}">
                    @if ($errors->has('address'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('address') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Link</span>
                    <textarea name="link">{{old('link')}}</textarea>
                    @if ($errors->has('link'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('link') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Description</span>
                    <textarea name="description">{{old('description')}}</textarea>
                    @if ($errors->has('description'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('description') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <label class="fullField">
                    <span>Summary</span>
                    <textarea name="summary">{{old('summary')}}</textarea>
                    @if ($errors->has('summary'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('summary') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>

                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <br>
                <br>
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
        $('.categories').select2();
    });

    $(document).ready(function() {
        $('.majors').select2();
        $('.unis').select2();
    });

    var category_id = 0;
    var major_id = 0;
    var skip = 0;

    function selectMajor(elm)
    {
        major_id = elm.value;

        $("#major_categories option").each(function() {
            $(this).remove();
        });

        $.ajax({
            url: base_url + '/get-major-category',
            type : "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data : {'major_id':major_id},
            success: function(data){
                if(data.status)
                {
                    for(var i = 0; i < data.categories.length; i++) {
                        $('#major_categories').append(`<option value="${data.categories[i]['id']}">
                                       ${data.categories[i]['name']}
                                  </option>`);
                    }
                }
            }
        });
    }
    function selectCategory(elm)
    {
        category_id = elm.value;
    }
    function addSub() {
        $.ajax({
            url: base_url + '/add/sub/category',
            type : "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data : {'skip': 0,'major_id':major_id , 'category_id':category_id,"_token": "{{ csrf_token() }}"},
            success: function(data){
                if(!data.status)
                {
                    $('#submit_button').prop('disabled', true);
                    $('.majors').prop('disabled', true);
                    $('.categories').prop('disabled', true);
                    skip = data.skip;
                    $('#status').text(data.inserted+' sub categories added');
                    addSub();
                }
                else {
                    $('#submit_button').prop('disabled', false);
                    $('#status').text('All categories are added');
                    $('.majors').prop('disabled', false);
                    $('.categories').prop('disabled', false);
                }
            }
        });
    }

</script>
