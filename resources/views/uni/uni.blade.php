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
            {{csrf_field()}}
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Detail</th>
                <th>Status</th>
                <th>Actions</th>
                <th>@if(count($unis) > 0) <input class="btn btn-primary submit" id="bulk_button"  type="submit" value="Delete" > @endif</th>
            </tr>
            </thead>
            <tbody id="sortable">
            @if(isset($unis))
                @foreach($unis as $uni)
                    <tr id="{{$uni->id}}">
                        <td>{{$uni->name}}</td>
                        <td>{{$uni->uni_detail}}</td>
                        <td>@if($uni->status == 1)<a href={{url('/')}}/uni/detail/{{$uni->id}}>View</a>@endif</td>
                        <td>@if($uni->status == 0) <a href="{{url('/uni/status/'.$uni->id.'/1')}}">Activate</a> @else <a href="{{url('/uni/status/'.$uni->id.'/0')}}">De Activate</a> @endif</td>
                        <td class="list-table">
                            <a href={{url('/')}}/update/uni/{{$uni->id}}><i class="fa fa-edit fa-fw "></i></a>
                            <a href={{url('/')}}/delete/uni/{{$uni->id}}><i class="fa fa-trash fa-fw "></i></a>
                        </td>
                        <td><input class="delete_check" type="checkbox" id="bulk_check" value="{{$uni->id}}" name="delete_ids[]"></td>
                    </tr>
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
