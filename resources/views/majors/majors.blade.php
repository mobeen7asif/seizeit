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
        <a class="btn btn-primary add_s" href="{{url('/')}}/add/major">Add New Major</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Majors</h2>
        @if ($errors->has('delete_ids'))
            <div class="alert alert-danger">
                @foreach ($errors->get('delete_ids') as $message)
                    {{ $message }}<br>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{url('/')}}/major/bulk/delete">
            {{csrf_field()}}
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Detail</th>
                <th>Actions</th>
                <th>@if(!$majors->isEmpty()) <input class="btn btn-danger submit" id="bulk_button"  type="submit" value="Delete" > @endif</th>
            </tr>
            </thead>
            <tbody id="sortable">
            @if(isset($majors))
                @foreach($majors as $major)
                    <tr id="{{$major->id}}">
                        <td>{{$major['name']}}</td>
                        <td><a href={{url('/')}}/major/detail/{{$major->id}}>View</a></td>
                        <td>
                            <a href={{url('/')}}/update/major/{{$major->id}}><i class="fa fa-edit fa-fw"></i></a>
                            <a href={{url('/')}}/delete/major/{{$major->id}}><i class="fa fa-trash fa-fw "></i></a>
                        </td>
                        <td><input class="delete_check" type="checkbox" value="{{$major->id}}" name="delete_ids[]"></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        </form>
        @if(!$majors->isEmpty()) <p><label><input type="checkbox" id="checkAll"/> Check all</label></p> @endif
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
                    url: base_url + '/sort/majors',
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
