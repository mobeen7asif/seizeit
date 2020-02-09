<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>

<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content lifeContent">
{{--{{dd($title)}}--}}
    @if(\Session::has('success'))
        <h4 class="alert alert-success fade in">
            {{\Session::get('success')}}
        </h4>
    @endif

    <div class="contentPd">
        {{--{{dd(!$users->isEmpty())}}--}}
        <h2 class="mainHEading">Admins</h2>
        @if ($errors->has('delete_ids'))
            <div class="alert alert-danger">
                @foreach ($errors->get('delete_ids') as $message)
                    {{ $message }}<br>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{url('/')}}/admin/bulk/delete">
            {{csrf_field()}}
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Actions</th>
                <th>@if(!$users->isEmpty()) <input class="btn btn-danger submit" id="bulk_button"  type="submit" value="Delete" > @endif</th>
            </tr>
            </thead>
            <tbody id="sortable">
            @if(isset($users))
                @foreach($users as $user)
                    <tr id="{{$user->id}}">
                        <td>{{$user['user_name']}}</td>
                        <td>{{$user['email']}}</td>
                        <td>
                            @if(Auth::user()->user_type == 2)
                                <a href={{url('/')}}/update/admin/{{$user->id}}><i class="fa fa-edit fa-fw "></i></a>
                                <a href={{url('/')}}/delete/admin/{{$user->id}}><i class="fa fa-trash fa-fw "></i></a>
                            @endif
                        </td>
                        <td>@if(Auth::user()->user_type == 2)<input class="delete_check" type="checkbox" value="{{$user->id}}" name="delete_ids[]"> @endif</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        </form>
    </div>
    @if(!$users->isEmpty())
        @if(Auth::user()->user_type == 2)
        <p><label><input type="checkbox" id="checkAll"/> Check all</label></p>
            @endif
    @endif

</section>

<script src="<?php echo url('/');?>/js/jquery.min.js"></script>
<script src="<?php echo url('/'); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo url('/'); ?>/js/jquery.dataTables.js"></script>

<script src="<?php echo asset('/'); ?>/js/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>


<script type="text/javascript" src="<?php echo url('/'); ?>/js/multi_select.js"></script>






</body>
</html>



<script>
    $(document).ready(function() {
        $('ul li:nth-child(5n)').addClass('fifth-child');
        $('ul li:nth-child(4n)').addClass('fourth-child');
        $('ul li:nth-child(3n)').addClass('third-item');
        $('ul li:first-child').addClass('first-item');
        $('ul li:last-child').addClass('last-item');
        $('.wrapper .box01:last-child,.wrapper .box02:last-child').addClass('last-item');
        $('ul li').addClass('odd-item');
        $('ul li:nth-child(2n)').removeClass('odd-item').addClass('even-item');
        $('.simple-list02 li:nth-child(4n)').addClass('fourth-child');
        $(".mobile-btn").click(function(){
            $(".main-nav").slideToggle();
            var hasclass = $("#navIcon").hasClass('fa-navicon');
            if(hasclass){
                $("#navIcon").removeClass('fa-navicon').addClass('fa-close');
            }
            else {
                $("#navIcon").addClass('fa-navicon').removeClass('fa-close');
            }
        });

        $('#chooseFile').bind('change', function () {
            var filename = $("#chooseFile").val();
            if (/^\s*$/.test(filename)) {
                $(".file-upload").removeClass('active');
                $("#noFile").text("No file chosen...");
            }
            else {
                $(".file-upload").addClass('active');
                $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
            }
        });
    });


    $(window).on('scroll',function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 300) {
            $(".header").addClass("stikyHead");
        } else {
            $(".header").removeClass("stikyHead");
        }
    });
    // $('.navList li').each(function(){
    //     if(window.location.href.indexOf($(this).find('a:first').attr('href'))>-1)
    //     {
    //         $(this).addClass('active').siblings().removeClass('active');
    //     }
    // });
    $(document).ready(function () {
        $('#bulk_button').hide();
        $('#tableStyle').DataTable({
            columnDefs: [{
                targets: [0],
                orderData: [0, 1]
            }, {
                targets: [1],
                orderData: [1, 0]
            }, {
                targets: [1],
                orderData: [1, 0]
            }],
            order: [[0, false]],
            bSort: false
        });
    });
    $('.mainNav').mCustomScrollbar({
        theme: "dark-3"
    });







    $(function() {
        $("#sortable").sortable();
        $("#sortable").disableSelection();
    });


//    $("#sortable").on("sortupdate", function( event, ui ) {
//
//        //var sortedIDs = $("#sortable").sortable("toArray");
//        var data = $('#sortable').sortable('serialize');
//        console.log(data);
//    });

    $('#sortable').sortable({
        axis: 'y',
        stop: function (event, ui) {
            $.map($(this).find('tr') , function(el){
                var itemId = el.id;
                var itemIndex = $(el).index();
                console.log(itemId);
                console.log(itemIndex);
                var base_url = "<?php echo url('/'); ?>";
                $.ajax({
                    url: base_url + '/sort/users',
                    type : "POST",
                    dataType : 'json',
                    data : {itemId:itemId , itemIndex:itemIndex},
                    success: function(data){
                        console.log('success');
                    }
                });
            })
        }
    });

    $('.delete_check').click (function ()
    {
        if($('.delete_check:checked').size() > 0){
            //$('.admin_check').disable();
            $("input.admin_check").prop("disabled", true);
            $('#bulk_button').show();
            $('#bulk_button').val('Delete');
        }else{
            $("input.admin_check").prop("disabled", false);
            $('#bulk_button').hide();
        }
    });


    //admin checkbox code
    $('.admin_check').click (function ()
    {
        if($('.admin_check:checked').size() > 0){
            //$('.delete_check').disable();
            $("input.delete_check").prop("disabled", true);
            $('#bulk_button').show();
            $('#bulk_button').val('Make Admin');
        }else{
            $("input.delete_check").prop("disabled", false);
            $('#bulk_button').hide();

        }
    });


    $("#checkAll").change(function () {
        $("input.delete_check").prop('checked', $(this).prop("checked"));
        if($('#checkAll:checked').size() > 0){
            $("input.admin_check").prop("disabled", true);
            $('#bulk_button').show();
            $('#bulk_button').val('Delete');
        }else{
            $('#bulk_button').hide();
            $("input.admin_check").prop("disabled", false);
        }


    });



</script>
