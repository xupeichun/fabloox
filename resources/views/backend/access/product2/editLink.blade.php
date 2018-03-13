@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
    <h1>
        Product Management
        <small>Edit Product Links</small>
    </h1>
@endsection

@section('content')


    {{ Form::open(['route' => ['admin.access.product.update.links'],  'class' => 'form-group form-horizontal', 'role' => 'form', 'method' => 'POST']) }}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Links</h3>

            <div class="box-tools pull-right">
                @include('backend.access.product.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="edit_url_container">

                @foreach($result as $data)
                    <div class="form-group link_row">
                        <input type="hidden" name='id[]' value="{{$data->id}}">
                        <label class="col-lg-2 control-label">Url</label>
                        <div class="col-lg-6">
                            <input class="form-control" required="required"
                                   autofocus="autofocus" placeholder="Enter Url" name='url[]'
                                   type="url" value="@if(isset($data->url)){{$data->url}}@endif">
                        </div>

                        <div class="col-lg-2">
                            <a class="btn btn-danger btn-md link_delete_btn"
                               data-id="@if(isset($data->id)){{$data->id}}@endif">Delete</a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{--<div class="form-group">--}}
            {{--<div class="col-lg-12">--}}
            {{--<div class="pull-right">--}}
            {{--<a class="btn btn-warning btn-md add_ans">Add Url</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-success">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.user.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
            </div><!--pull-left-->

            <div class="pull-right">
                {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-success btn-xs']) }}
            </div><!--pull-right-->

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->


    {{ Form::close() }}
@endsection

@section('after-scripts')
    {{ Html::script('js/backend/access/users/script.js') }}
    <script>
        $(document).ready(function () {
            $(document).delegate('.link_delete_btn',"click", function () {
                var btn_object = $(this).closest('.link_row');
                var id = $(this).data('id');
                console.log($(this).closest('.link_row'));
                swal({
                    title: 'Are you sure you want to delete?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }, function () {

                    $.ajax({
                        url: "{{ route("admin.access.product.delete.links") }}",
                        data: {
                            'id': id,
                        },
                        type: 'POST',


                    }).done(function (data) {
                        if (data.status == 200){
                            $(btn_object).remove();
                        }
                    });
                })
            });
        })
    </script>

@endsection
