<table class="table table-responsive" id="brandVideos-table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Brand Id</th>
        <th>Image</th>
        <th colspan="3">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($brandVideos as $brandVideo)
        <tr>
            <td>{!! $brandVideo->name !!}</td>
            <td>{!! $brandVideo->brand_id !!}</td>
            <td>{!! $brandVideo->image !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.brandVideos.destroy', $brandVideo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.brandVideos.show', [$brandVideo->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.brandVideos.edit', [$brandVideo->id, 'brand_id' => request()->brand_id ]) !!}"
                       class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>