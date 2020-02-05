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
        <div id="loader" style="display: none">
            <img src="{{url('')}}/images/loader.gif">
        </div>
        <div  class="userForm user">

            @if(\Session::has('success'))
                <h4 class="alert alert-success fade in">
                    {{\Session::get('success')}}
                </h4>
            @endif
            {{csrf_field()}}


            <label class="fullField">
                <span>Select Uni</span>
                <select class="unis" name="majors" multiple onchange="selectUni(this)">
                    @foreach($unis as $uni)
                        <option value="{{$uni->id}}">{{$uni->name}}</option>
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
                <span>Select Major</span>
                <select class="majors" name="majors" multiple onchange="selectMajor(this)">
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
                <select id="major_categories" class="categories" multiple name="categories" onchange="selectCategory(this)">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('categories'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('categories') as $message)
                            {{ $message }}<br>
                        @endforeach
                    </div>
                @endif
            </label>

                <label class="fullField">
                    <span>Select Link</span>
                    <select  class="links" name="links" onchange="selectLink(this)">
                        <option value="0">Select Link</option>
                        @foreach($links as $link)
                            <option value="{{$link->id}}">{{$link->link}}</option>
                        @endforeach
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
                <input class="btn btn-primary" id="submit_button" onclick="addSub(this)" type="button" name="signIn"  value="Submit">
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
    $(document).ready(function() {
        $('.unis').select2();
    });
    $(document).ready(function() {
        $('.links').select2();
    });

    var category_id = 0;
    var major_id = 0;
    var skip = 0;

    var unis = [];
    var majors = [];
    var categories = [];
    var link = '';

    function selectUni(uni) {
        unis = $('.unis').val();
    }
    function selectMajor(uni) {
        majors = $('.majors').val();
    }
    function selectCategory(elm)
    {
        categories = $('.categories').val();
    }
    function selectLink(elm) {
        link = $('.links').val();
    }
/*    $('.unis').on('select2:unselecting', function (e) {
        alert('You clicked on X'+e.value);
    });
    $('.unis').on('select2:selecting', function (e) {
        alert('You asdasd on X'+e.value);
    });*/


    function addSub() {
        if(unis.length == 0) {
            alert('Please select uni');
            return false;
        }
        if(majors.length == 0) {
            alert('Please select major');
            return false;
        }
        if(link == 0) {
            alert('Please select link');
            return false;
        }
        if(categories.length == 0) {
            alert('Please select category');
            return false;
        }
        $('#submit_button').prop('disabled', true);
        $('#submit_button').addClass('disable_cursor');
        $('.unis').prop('disabled', true);
        $('.majors').prop('disabled', true);
        $('.categories').prop('disabled', true);
        $('#loader').show();

        $.ajax({
            url: base_url + '/add/sub/category',
            type : "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data : {'skip': 0,'major_id':majors , 'link': link,'category_id':categories,'uni_id':unis,"_token": "{{ csrf_token() }}"},
            success: function(data){
                if(data.status == 500){
                    $('#loader').hide();
                    alert('Something went wrong');
                }
                else {
                    $('#loader').hide();
                    alert(data.message);
                    $('#submit_button').prop('disabled', false);
                    $('#submit_button').addClass('disable_cursor');
                    $('.unis').prop('disabled', false);
                    $('.majors').prop('disabled', false);
                    $('.categories').prop('disabled', false);
                }
            }
        });
    }

</script>
