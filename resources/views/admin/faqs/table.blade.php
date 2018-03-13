<table class="table table-responsive" id="faqs-table">
    <thead>
        <tr>
            <th>Question</th>
        <th>Answer</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($faqs as $faqs)
        <tr>
            <td>{!! $faqs->question !!}</td>
            <td>{!! $faqs->answer !!}</td>
            <td>
                {{--{!! Form::open(['route' => ['admin.faqs.destroy', $faqs->id], 'method' => 'delete']) !!}--}}
                <div class='btn-group'>
                    <a href="{!! route('admin.faqs.show', [$faqs->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.faqs.edit', [$faqs->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['class' => 'btn btn-danger btn-xs delete_btn', 'id'=>$faqs->id]) !!}
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
                url: "{{ url("admin/faqs") }}/" + id,
                type: 'post',
                data:{"_method":'DELETE',"token":"{{csrf_token()}}"}


            }).done(function () {
                $('#' + id).closest('tr').remove();

            });
        })
    });
</script>