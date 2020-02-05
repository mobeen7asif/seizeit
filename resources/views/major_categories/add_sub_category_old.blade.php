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
                {{csrf_field()}}
                <label class="fullField">
                    <span>Select Major</span>
                    <select class="majors" name="majors" onchange="selectMajor(this)">
                        <option value="0">Select Major</option>
                        @foreach($majors as $major)
                            <option @if(request()->route()->parameter('major_id') == $major->id) selected @endif value="{{$major->id}}">{{$major->name}}</option>
                        @endforeach

                    </select>
                    @if ($errors->has('majors'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('majors') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>

                <label class="fullField">
                    <span>Select Category</span>
                    <select id="major_categories" class="categories" name="categories" onchange="selectCategory(this)">
                    </select>
                    @if ($errors->has('categories'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('categories') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                <span style="font-weight: bold" id="status"></span>
                <br>
                <br>
                <div class="btnCol">
                    <input id="submit_button" onclick="addSub(this)" type="button" name="signIn"  value="Submit">
                </div>
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
                    if(data.categories.length > 0) {
                        category_id = data.categories[0]['id'];
                        for(var i = 0; i < data.categories.length; i++) {
                            $('#major_categories').append(`<option value="${data.categories[i]['id']}">
                                       ${data.categories[i]['name']}
                                  </option>`);
                        }
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
        if(major_id == 0) {
            alert('Please select major');
            return false;
        }
        $.ajax({
            url: base_url + '/add/sub/category',
            type : "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data : {'skip': 0,'major_id':major_id , 'category_id':category_id,"_token": "{{ csrf_token() }}"},
            success: function(data){
                if(data.status == 500){
                    alert('Something went wrong');
                }
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
