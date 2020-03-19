<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/includes/head.php'); ?>
<body>

<?php include resource_path('views/includes/header.php'); ?>
<?php include resource_path('views/includes/sidebar.php'); ?>
<section class="content lifeContent">

    @if(\Session::has('success'))
        <h4 class="alert alert-success fade in">
            {{\Session::get('success')}}
        </h4>
    @endif
        <a class="btn btn-primary add_s" href="{{url('/')}}/transfer/data" >Transfer Uni Data</a>
        <a class="btn btn-primary add_s" href="{{url('/')}}/add/uni" >Add New Uni</a>
        <form class="add_s" action="{{url('/')}}/uni" method="get">
            <input name="sort_status" value="0" type="hidden">
            {{--<input type="submit" name="submit" value="Sort By Name">--}}
        </form>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Universities</h2>
        @if ($errors->has('delete_ids'))
            <div class="alert alert-danger">
                @foreach ($errors->get('delete_ids') as $message)
                    {{ $message }}<br>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{url('/')}}/uni/bulk/delete">

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
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Detail</th>
                <th>Status</th>
                <th>Actions</th>
                <th>@if(count($unis) > 0) <input data-toggle="modal" data-target="#delete-all" class="btn btn-danger submit" id="bulk_button"  type="button" value="Delete"> @endif</th>
            </tr>
            </thead>
            <tbody id="sortable">
            @if(isset($unis))
                @foreach($unis as $uni)
                    <tr id="{{$uni->id}}">
                        <td><img style="height: auto; width: 20%" src="{{isset($uni->image) ? url('/').$uni->image : url('/images/no_image.jpg')}}"/></td>
                        <td>{{$uni->name}}</td>
                        <td>@if($uni->status == 1)<a href={{url('/')}}/uni/detail/{{$uni->id}}>View</a>@endif</td>
                        <td>@if($uni->status == 0) <a href="{{url('/uni/status/'.$uni->id.'/1')}}">Activate</a> @else <a href="{{url('/uni/status/'.$uni->id.'/0')}}">De Activate</a> @endif</td>
                        <td class="list-table">
                            <a href={{url('/')}}/update/uni/{{$uni->id}}><i class="fa fa-edit fa-fw "></i></a>
                            <a data-toggle="modal" data-target="#deletePopup-{{$uni->id}}" href="#"><i class="fa fa-trash fa-fw "></i></a>
                        </td>
                        <td><input class="delete_check" type="checkbox" id="bulk_check" value="{{$uni->id}}" name="delete_ids[]"></td>
                    </tr>

                    <!-- Delete Model-->
                    <div class="modal fade deletePopup" id="deletePopup-{{$uni->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content delete-popup">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="modal-body">
                                    <div class="txt">
                                        <h2>Confirmation Message</h2>
                                        <p>Would you really want to delete?</p>
                                    </div>
                                    <a class="btn btn btn-black" href={{url('/')}}/delete/uni/{{$uni->id}}>Yes</a>
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
        @if(count($unis) > 0) <p><label><input type="checkbox" id="checkAll"/> Check all</label></p> @endif
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>

<script>

    $(function() {
        $("#sortable").sortable();
        $("#sortable").disableSelection();
    });




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
                    url: base_url + '/sort/uni',
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
</script>
