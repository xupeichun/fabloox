@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
    <h1>
        Gallery Management     </h1>
@endsection

@section('content')
{{--{{dd($brand->end_date)}}--}}

    {{ Form::open(['route' => ['admin.access.gallery.update',$brand->id],  'class' => 'form-group form-horizontal', 'role' => 'form', 'method' => 'PATCH','enctype'=>"multipart/form-data"]) }}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Image</h3>
            <input type="hidden" name="id" value="{{$brand->id}}">
            <div class="box-tools pull-right">
                @include('backend.access.gallery.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('Start Date', 'Start Date', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-6 col-xs-12">
                    <div class='input-group date' id="start_datetimepicker">
                        <input type='text' class="form-control" name="start_date" value="{{$brand->start_date}}" readonly />
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('End Date', 'End Date', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-6 col-xs-12">
                    <div class='input-group date' id='end_datetimepicker'>
                        <input type='text' class="form-control" value="{{$brand->end_date}}" name="end_date" readonly/>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('Image', 'Image', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-6">
                    <input type="file" name="image">
                    <input type="hidden"  name="img_status" value="exist">
                </div>
                <div class="col-lg-4">
                    <img class="img-responsive" src="{{asset('/')}}{{$brand->image}}" alt="">
                </div>
            </div>

        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-success">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.gallery.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
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

        $(function () {
            $('#start_datetimepicker').datetimepicker({
                sideBySide:true,
                format: 'YYYY-MM-DD HH:mm:ss',
                ignoreReadonly: true,
            });
            $('#end_datetimepicker').datetimepicker({
                sideBySide:true,
                ignoreReadonly: true,
                format: 'YYYY-MM-DD HH:mm:ss',
            });
        });
    </script>
@endsection
