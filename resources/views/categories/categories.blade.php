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
        <a class="btn btn-primary add_s" href="{{url('/')}}/add/category">Add New Category</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Categories</h2>
        @if ($errors->has('delete_ids'))
            <div class="alert alert-danger">
                @foreach ($errors->get('delete_ids') as $message)
                    {{ $message }}<br>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{url('/')}}/category/bulk/delete">
            {{csrf_field()}}
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Detail</th>
                <th>Actions</th>
                <th>@if(!$categories->isEmpty()) <input class="submit btn btn-danger" id="bulk_button"  type="submit" value="Delete"> @endif</th>
            </tr>
            </thead>
            <tbody id="sortable">
            @if(isset($categories))
                @foreach($categories as $category)
                    <tr id="{{$category->id}}">
                        <td><img style="height: 25%; width: 25%" src="{{isset($category->image) ? url('/').$category->image : url('/images/no_image.jpg')}}"/></td>
                        <td>{{$category->name}}</td>
                        <td><a href={{url('/')}}/category/detail/{{$category->id}}>View</a></td>
                        <td>
                            <a href={{url('/')}}/update/category/{{$category->id}}><i class="fa fa-edit fa-fw"></i></a>
                            <a href={{url('/')}}/delete/category/{{$category->id}}><i class="fa fa-trash fa-fw "></i></a>
                        </td>
                        <td><input class="delete_check" type="checkbox" value="{{$category->id}}" name="delete_ids[]"></td>
                    </tr>

                    <div class="modal fade" id="model-{{$category->id}}" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Select Major</h4>
                                </div>
                                <div class="modal-body">
                                    <select class="majors" name="majors">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach

                                    </select>
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
        @if(!$categories->isEmpty()) <p><label><input type="checkbox" id="checkAll"/> Check all</label></p> @endif
    </div>
</section>
<?php include resource_path('views/includes/footer.php'); ?>

<script>

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
                    url: base_url + '/sort/categories',
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
