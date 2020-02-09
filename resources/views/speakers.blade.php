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
        <a class="add_s" href="{{url('/')}}/add/speaker" >Add New Speaker</a>

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Speakers</h2>
        @if ($errors->has('delete_ids'))
            <div class="alert alert-danger">
                @foreach ($errors->get('delete_ids') as $message)
                    {{ $message }}<br>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{url('/')}}/speaker/bulk/delete">
            {{csrf_field()}}
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Description</th>
                <th>Actions</th>
                <th>@if(!$speakers->isEmpty()) <input class="submit"  type="submit" value="Delete" id="bulk_btn" > @endif</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($speakers))
                @foreach($speakers as $speaker)
                    <tr>
                        <td>{{$speaker['name']}}</td>
                        <td>{{$speaker['designation']}}</td>
                        <td><a href={{url('/')}}/speaker/detail/{{$speaker->id}}>View</a></td>
                        <td class="list-table">
                            <a href={{url('/')}}/update/speaker/{{$speaker->id}}><i class="fa fa-edit fa-fw "></i></a>
                            <a href={{url('/')}}/delete/speaker/{{$speaker->id}}><i class="fa fa-trash fa-fw "></i></a>
<input type="checkbox" id="bulk_check" value="{{$speaker->id}}" name="delete_ids[]">
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

        </form>
    </div>
</section>
<script src="{{url('/')}}/js/jquery.min.js"></script>
<script src="{{url('/')}}/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/js/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/mian.js"></script>

<script>
    $(document).ready(function () {
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


</script>

</body>
</html>
