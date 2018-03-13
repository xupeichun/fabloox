@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.create'))

@section('page-header')
    <h1>
        Gallery Management
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.access.gallery.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','enctype'=>"multipart/form-data"]) }}

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Add Image</h3>

            <div class="box-tools pull-right">
                @include('backend.access.gallery.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('Image', 'Image', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <input type="file" name="image" required>
                    <input type="hidden"  name="img_status" value="notExist">
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('Start Date', 'Start Date', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-6 col-xs-12">
                    <div class='input-group date' id="start_datetimepicker">
                        <input type='text' class="form-control" name="start_date" readonly />
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
                        <input type='text' class="form-control" name="end_date" readonly/>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>

        </div>
    </div><!--box-->

    <div class="box box-info">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.gallery.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
            </div><!--pull-left-->

            <div class="pull-right">
                {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-xs']) }}
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
                format: 'DD-MM-YYYY HH:mm',
                ignoreReadonly: true
            });
            $('#end_datetimepicker').datetimepicker({
                sideBySide:true,
                ignoreReadonly: true,
                format: 'DD-MM-YYYY HH:mm'

            });
        });
    </script>
@endsection
