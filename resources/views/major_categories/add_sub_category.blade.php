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
                            <option value="{{$link->id}}">{{$link->name}}</option>
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

                <div class="job_link">
                    <label class="fullField">
                        <span>Job Title</span>
                        <input type="text" class="job" name="name" onchange="selectJobTitle(this)">
                    </label>

                    <label class="fullField">
                        <span>Job Location</span>
                        <input type="text" class="job" name="name" onchange="selectJobLocation(this)">
                    </label>

                    <label class="fullField radius_label">
                        <span>Select Radius</span>
                        <select  class="radius" name="radius" onchange="selectRadius(this)">
                            <option selected value="5">5 Miles</option>
                            <option value="10">10 Miles</option>
                            <option value="15">15 Miles</option>
                            <option value="25">20 Miles</option>
                            <option value="50">50 Miles</option>
                            <option value="100">100 Miles</option>
                        </select>
                    </label>
                </div>






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


    var job_title = "";
    var job_location = "";
    var category_id = 0;
    var major_id = 0;
    var skip = 0;

    var unis = [];
    var majors = [];
    var categories = [];
    var link = '';
    var radius = 5;

    $(document).ready(function() {
        $('.categories').select2();
        $('.job_link').hide();
        $('.internship_link').hide();
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

    $(document).ready(function() {
        $('.radius').select2();
    });

    var selected_link = "";
    $('.links').change(function () {
        selected_link = $(".links option:selected").text();
        if(selected_link == 'Jobs' || selected_link == 'Internships') {
            $('.job_link').show();
        }
        else {
            $('.job_link').hide();
            job_title = "";
            job_location = "";
            $('.job').val('');
        }

    });





    function selectJobTitle(title) {
        job_title = title.value;
    }

    function selectJobLocation(location) {
        job_location =  location.value;
    }

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
    function selectRadius(elm) {
        radius = elm.value;
    }






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
        if(selected_link == "Jobs" || selected_link == "Internships") {
            if(job_title.length == 0) {
                alert('Please select job title');
                return false;
            }
            if(job_location.length == 0) {
                alert('Please select job location');
                return false;
            }
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
            data : {'radius': radius,'selected_link':selected_link,'job_title':job_title,'job_location': job_location,'skip': 0,'major_id':majors , 'link': link,'category_id':categories,'uni_id':unis,"_token": "{{ csrf_token() }}"},
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
