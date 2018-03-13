<table class="table table-responsive" id="pushNotifications-table">
    <thead>
    <tr>
        <th>Subject</th>
        <th>Date</th>
        <th>Time</th>
        <th>Sent</th>
        <th colspan="3">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pushNotifications as $pushNotification)
        <tr>
            <td>{!! $pushNotification->title !!}</td>
            <td>{!! date("d-m-Y", strtotime($pushNotification->time)) !!}</td>
            <td>{!! date("h:i:s a", strtotime($pushNotification->time)) !!}</td>
            <td>{!! $pushNotification->notification_sent_at?'Yes':'no' !!}</td>
            <td>
                {{--{!! Form::open(['route' => ['admin.pushNotifications.destroy', $pushNotification->id], 'method' => 'delete']) !!}--}}
                <div class='btn-group'>
                    <a href="{!! route('admin.pushNotifications.show', [$pushNotification->id]) !!}"
                       class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.pushNotifications.edit', [$pushNotification->id]) !!}"
                       class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['class' => 'btn btn-danger btn-xs delete_btn','id'=>$pushNotification->id]) !!}
                </div>
                {{--{!! Form::close() !!}--}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    $("body").on("click", ".delete_btn", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');

        swal({
            title: 'Are you sure you want to delete?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }, function () {

            $.ajax({
                url: "{{ url("admin/pushNotifications") }}/" + id,
                type: 'post',
                data:{"_method":'DELETE',"token":"{{csrf_token()}}"}


            }).done(function () {
                $('#' + id).closest('tr').remove();

            });
        })
    });
</script>