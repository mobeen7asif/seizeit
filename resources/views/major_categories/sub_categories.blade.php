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
            {{csrf_field()}}
        <table id="mytable" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Uni</th>
                <th>Major</th>
                <th>Category</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
                <th>@if(!$data->isEmpty()) <input class="btn btn-danger submit" id="bulk_button"  type="submit" value="Delete"> @endif</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($data))
                @foreach($data as $dat)
                    <tr id="{{$dat->id}}">
                        <td>{{$dat->uni->name}}</td>
                        <td>{{isset($dat->major) ? $dat->major->name : ''}}</td>
                        <td>{{isset($dat->category)? $dat->category->name: ''}}</td>
                        <td>{{$dat->title}}</td>
                        <td style="cursor: pointer"><a data-toggle="modal" data-target="#model-{{$dat->id}}">View</a></td>
                        {{--<td>{{\Illuminate\Support\Str::limit($dat->email,10)}}</td>
                        <td>{{\Illuminate\Support\Str::limit($dat->link,10)}}</td>--}}

                        <td>
                            <a href={{url('/')}}/update/sub/category/{{$dat->id}}><i class="fa fa-edit fa-fw"></i></a>
                            <a href={{url('/')}}/delete/sub/category/{{$dat->id}}><i class="fa fa-trash fa-fw "></i></a>
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
                                    <P>{{$dat->title}}</P>
                                    <br>
                                    <span><b>Category</b></span>
                                    <P>{{$dat->title}}</P>
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
                                    <P>{{$dat->description}}</P>
                                    <br>
                                    <span><b>Summary</b></span>
                                    <P>{{$dat->summary}}</P>
                                    <br>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
