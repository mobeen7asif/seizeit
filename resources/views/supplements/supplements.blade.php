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
        <a class="add_btn add_s" href="{{url('/')}}/add/supplement">Add Supplement</a>
    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Supplemental Materials</h2>
        @if ($errors->has('delete_ids'))
            <div class="alert alert-danger">
                @foreach ($errors->get('delete_ids') as $message)
                    {{ $message }}<br>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{url('/')}}/supplement/bulk/delete">
            {{csrf_field()}}
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>View Detail</th>
                <th>Actions</th>
                <th>@if(!$supplements->isEmpty()) <input class="submit" id="bulk_button"  type="submit" value="Delete" > @endif</th>

            </tr>
            </thead>
            <tbody id="sortable">
            @if(isset($supplements))
                @foreach($supplements as $supplement)
                    <tr id="{{$supplement->id}}">
                        <td>{{$supplement['name']}}</td>
                        <td>{!! str_limit($supplement['detail'],50) !!}</td>
                        <td><a href="{{url('/')}}/supplement/detail/{{$supplement->id}}">Detail</a></td>
                        <td>
                            <a href={{url('/')}}/update/supplement/{{$supplement->id}}><i class="fa fa-edit fa-fw"></i></a>
                            <a href={{url('/')}}/delete/supplement/{{$supplement->id}}><i class="fa fa-trash fa-fw "></i></a>
                        </td>
                        <td><input class="delete_check" type="checkbox" value="{{$supplement->id}}" name="delete_ids[]"></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        </form>
        @if(!$supplements->isEmpty()) <p><label><input type="checkbox" id="checkAll"/> Check all</label></p> @endif
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
                    url: base_url + '/sort/supplements',
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
