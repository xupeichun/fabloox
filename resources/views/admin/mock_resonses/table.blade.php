<table class="table table-responsive" id="mockResonses-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Url</th>
        <th>Response</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($mockResonses as $mockResonse)
        <tr>
            <td>{!! $mockResonse->name !!}</td>
            <td>{!! $mockResonse->url !!}</td>
            <td>{!! $mockResonse->response !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.mockResonses.destroy', $mockResonse->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.mockResonses.show', [$mockResonse->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.mockResonses.edit', [$mockResonse->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>