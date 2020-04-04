<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>
<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content publicContent editEvent">

    <div class="content lifeContent">
        <div class="heading-sponser">
        <h2>Transfer Data</h2>
            <a class="btn btn btn-primary back" href="{{url('/')}}/uni">Back</a>
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
                <span class="required">Select Uni (From)</span>
                <select class="unis" name="majors"  onchange="selectUni(this)">
                    <option value="">Select Uni</option>
                    @foreach($unis as $uni)
                        <option value="{{$uni->id}}">{{$uni->name}}</option>
                    @endforeach

                </select>
                @if ($errors->has('from_uni'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('from_uni') as $message)
                            {{ $message }}<br>
                        @endforeach
                    </div>
                @endif
            </label>

                <label class="fullField">
                    <span class="required">Select Uni (To)</span>
                    <select class="to_uni" name="majors"  onchange="selectToUni(this)">
                        <option value="">Select Uni</option>
                        @foreach($unis as $uni)
                            <option value="{{$uni->id}}">{{$uni->name}}</option>
                        @endforeach

                    </select>
                    @if ($errors->has('to_uni'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('to_uni') as $message)
                                {{ $message }}<br>
                            @endforeach
                        </div>
                    @endif
                </label>

            <label class="fullField">
                <span class="required">Select Category</span>
                <select id="major_categories" class="categories" multiple name="categories" onchange="selectCategory(this)">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('category'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('category') as $message)
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









<script>

    var category_id = 0;

    var unis = "";
    var to_unis = "";
    var categories = [];


    $(document).ready(function() {
        $('.unis').select2();
        $('.to_uni').select2();
        $('.categories').select2();

    });
    function selectUni(uni) {
        unis = $('.unis').val();
    }
    function selectToUni(uni) {
        to_unis = $('.to_uni').val();
    }

    function selectCategory(elm)
    {
        categories = $('.categories').val();
    }
    function addSub() {
        if(unis.length == 0) {
            alert('Please select uni');
            return false;
        }
        if(to_unis.length == 0) {
            alert('Please select uni');
            return false;
        }

        if(categories.length == 0) {
            alert('Please select category');
            return false;
        }
        $('#submit_button').prop('disabled', true);
        $('#submit_button').addClass('disable_cursor');
        $('.unis').prop('disabled', true);
        $('.to_unis').prop('disabled', true);
        $('.categories').prop('disabled', true);
        $('#loader').show();

        $.ajax({
            url: base_url + '/transfer-data',
            type : "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data : {'category_id':categories,'uni_id':unis,'to_uni_id':to_unis,"_token": "{{ csrf_token() }}"},
            success: function(data){
                if(!data.status){
                    $('#loader').hide();
                    alert('Something went wrong! Try again later');
                    $('#submit_button').prop('disabled', false);
                    $('#submit_button').addClass('disable_cursor');
                    $('.unis').prop('disabled', false);
                    $('.majors').prop('disabled', false);
                    $('.categories').prop('disabled', false);
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
