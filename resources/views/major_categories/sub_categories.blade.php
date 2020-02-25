<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<style>
    .select2-container {
        width: 200px !important;
    }
    .input-number {
        width: 80px;
        padding: 0 12px;
        vertical-align: top;
        text-align: center;
        outline: none;
    }

    .input-number,
    .input-number-decrement,
    .input-number-increment {
        border: 1px solid #ccc;
        height: 32px;
        user-select: none;
    }

    .input-number-decrement,
    .input-number-increment {
        display: inline-block;
        width: 30px;
        line-height: 30px;
        background: #f1f1f1;
        color: #444;
        text-align: center;
        font-weight: bold;
        cursor: pointer;
    }
    .input-number-decrement:active,
    .input-number-increment:active {
        background: #ddd;
    }

    .input-number-decrement {
        border-right: none;
        border-radius: 4px 0 0 4px;
    }

    .input-number-increment {
        border-left: none;
        border-radius: 0 4px 4px 0;
    }

</style>
<body>

<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>


@php

    function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
    @endphp
<section class="content lifeContent">

    @if(\Session::has('success'))
        <h4 class="alert alert-success fade in">
            {{\Session::get('success')}}
        </h4>
    @endif
        <a class="btn btn-primary add_s" href="{{url('/')}}/add/custom/category">Add Sub Category</a>
        <a class="btn btn-primary add_s" href="{{url('/')}}/add/sub/category">Scrap Categories</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Sub Categories</h2>
        @if ($errors->has('delete_ids'))
            <div class="alert alert-danger">
                @foreach ($errors->get('delete_ids') as $message)
                    {{ $message }}<br>
                @endforeach
            </div>
        @endif


            <form method="GET" action="{{url('/sub/categories')}}">


                <span class="input-number-decrement">–</span><input  name="page_size" class="input-number" type="text" @if(isset($_GET['page_size'])) value="{{$_GET['page_size']}}" @else value="10"   @endif min="5" max="100"><span class="input-number-increment">+</span>



                <select class="unis" name="unis">
                    <option value="0">Select Uni</option>
                    @foreach($unis as $uni)
                        <option @if(isset($_GET['unis']) and $_GET['unis'] == $uni->id) selected @endif value="{{$uni->id}}">{{$uni->name}}</option>
                    @endforeach
                </select>

                <select class="majors" name="majors">
                    <option value="0">Select Major</option>
                    @foreach($majors as $major)
                        <option @if(isset($_GET['majors']) and $_GET['majors'] == $major->id) selected @endif value="{{$major->id}}">{{$major->name}}</option>
                    @endforeach

                </select>
                <select id="major_categories" class="categories" name="categories">
                    <option value="0">Select Category</option>
                    @foreach($categories as $category)
                        <option @if(isset($_GET['categories']) and $_GET['categories'] == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                <input class="btn btn-primary" style="padding: 4px 12px;" type="submit" value="SEARCH">
                @if(isset($_GET) and count($_GET) > 0)<a href="{{url('/sub/categories')}}" class="btn btn-primary" style="padding: 4px 12px;">CLEAR </a> @endif
            </form>

        </div>
        <form method="post" action="{{url('/')}}/sub/category/bulk/delete">



            <!-- Delete Model-->
            <div class="modal fade deletePopup" id="delete-all" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content delete-popup">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="modal-body">
                            <div class="txt">
                                <h2>Confirmation Message</h2>
                                <p>Would you really want to delete?</p>
                            </div>
                            <input style="padding: 10px 50px;" class="btn btn btn-black" type="submit" value="YES" />
                        </div>
                    </div>
                </div>
            </div>

            {{csrf_field()}}
        <table id="mytable" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Uni</th>
                <th>Major</th>
                <th>Category</th>
                <th>
                    @php
                    $url = "";
                        $prev_params = "";
                            if(isset($_GET)) {
                                if(count($_GET) > 0) {
                                $prev_params = "";
                                foreach($_GET as $key => $value) {
                                if($key != "sort") {
                                $prev_params .= $key.'='.$value.'&';
                                }

                                }
                                }
                            }
                    if($prev_params == "") {
                        $url = url('/sub/categories');
                    }
                    else {
                    $url = url('/sub/categories')."?$prev_params";
                    }
                    @endphp
                    <div style="display: inline-block">
                        <a style="display: block;height: 5px" href="<?php echo $prev_params != "" ? $url.'sort=asc' : $url.'?sort=asc' ?>"><i class="fa fa-fw fa-sort-asc"></i></a>
                        <a style="display: block" href="<?php echo $prev_params != "" ? $url.'sort=desc' : $url.'?sort=desc' ?>"><i class="fa fa-fw fa-sort-desc"></i></a>
                    </div>

                    Title</th>
                <th>Description</th>
                <th>Actions</th>
                <th>@if(!$data->isEmpty()) <input data-toggle="modal" data-target="#delete-all" class="btn btn-danger submit" id="bulk_button"  type="button" value="Delete"> @endif</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($data))
                @foreach($data as $dat)
                    <tr id="{{$dat->id}}">
                        <td>{{$dat->uni->name}}</td>
                        <td>{{isset($dat->major) ? $dat->major->name : ''}}</td>
                        <td>{{isset($dat->category)? $dat->category->name: ''}}</td>
                        <td>{{htmlspecialchars_decode($dat->title)}}</td>
                        <td style="cursor: pointer"><a data-toggle="modal" data-target="#model-{{$dat->id}}">View</a></td>
                        {{--<td>{{\Illuminate\Support\Str::limit($dat->email,10)}}</td>
                        <td>{{\Illuminate\Support\Str::limit($dat->link,10)}}</td>--}}

                        <td>
                            <a href={{url('/')}}/update/sub/category/{{$dat->id}}><i class="fa fa-edit fa-fw"></i></a>
                            <a data-toggle="modal" data-target="#deletePopup-{{$dat->id}}" href="#"><i class="fa fa-trash fa-fw "></i></a>
                        </td>
                        <td><input class="delete_check" type="checkbox" value="{{$dat->id}}" name="delete_ids[]"></td>
                    </tr>

                    <div class="modal fade" id="model-{{$dat->id}}" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Detail</h4>
                                </div>
                                <div class="modal-body">
                                            <span><b>Uni</b></span>
                                            <P>{{$dat->uni->name}}</P>
                                            <br>
                                    <span><b>Major</b></span>
                                    <P>{{isset($dat->major) ? $dat->major->name : ''}}</P>
                                    <br>
                                    <span><b>Category</b></span>
                                    <P>{{$dat->category->name}}</P>
                                    <br>
                                    <span><b>Title</b></span>
                                    <P>{{App\Libs\Helpers\Helper::clean($dat->title)}}</P>
                                    <br>
                                    <span><b>Email</b></span>
                                    <P>{{$dat->email}}</P>
                                    <br>
                                    <span><b>Address</b></span>
                                    <P>{{$dat->address}}</P>
                                    <br>
                                    <span><b>Link</b></span>
                                    <P>{{$dat->link}}</P>
                                    <br>
                                    <span><b>Description</b></span>
                                    @php
                                        $str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
            }, htmlspecialchars_decode($dat->description));
                                    @endphp

                                    <p>{!! str_replace('\n','',$str) !!}</p>
                                    <br>
                                    <span><b>Summary</b></span>
                                    <?php print_r(str_replace('\n','',App\Libs\Helpers\Helper::clean($dat->summary))) ?>
                                    <br>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Model-->
                    <div class="modal fade deletePopup" id="deletePopup-{{$dat->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content delete-popup">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="modal-body">
                                    <div class="txt">
                                        <h2>Confirmation Message</h2>
                                        <p>Would you really want to delete?</p>
                                    </div>
                                    <a class="btn btn btn-black" href={{url('/')}}/delete/sub/category/{{$dat->id}}>Yes</a>
                                    <a class="btn btn btn-primary" href="#" data-dismiss="modal">No</a>
                                </div>
                            </div>
                        </div>
                    </div>







                @endforeach
            @endif
            </tbody>
        </table>
        </form>
        @if(!$data->isEmpty()) <p style="margin-top: 10px"><label><input type="checkbox" id="checkAll"/> Check all</label></p> @endif
        {{ $data->appends($_GET)->links() }}



</section>
<?php include resource_path('views/includes/footer.php'); ?>

<script src="{{ URL::to('src/js/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

<script>





    (function() {

        window.inputNumber = function(el) {

            var min = el.attr('min') || false;
            var max = el.attr('max') || false;

            var els = {};

            els.dec = el.prev();
            els.inc = el.next();

            el.each(function() {
                init($(this));
            });

            function init(el) {

                els.dec.on('click', decrement);
                els.inc.on('click', increment);

                function decrement() {
                    var value = el[0].value;
                    value--;
                    if(!min || value >= min) {
                        el[0].value = value;
                    }
                }

                function increment() {
                    var value = el[0].value;
                    value++;
                    if(!max || value <= max) {
                        el[0].value = value++;
                    }
                }
            }
        }
    })();

    inputNumber($('.input-number'));

    $(document).ready(function() {
        $('.categories').select2();
    });

    $(document).ready(function() {
        $('.majors').select2();
    });
    $(document).ready(function() {
        $('.unis').select2();
    });

    $(document).ready( function () {
        table =  $('#mytable').DataTable();
    });
    $('#mytable').dataTable({
        "bPaginate": false,
        "info":     false,
          "bSort": false,
        "bLengthChange": false,
        "bFilter": true,
    });
    $('.dataTables_filter').hide();

</script>
