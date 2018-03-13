@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
    <h1>
        Home Videos Management
    </h1>
@endsection

@section('content')


    {{ Form::open(['route' => ['admin.access.homepagevideo.update',$brand->id],  'class' => 'form-group form-horizontal', 'role' => 'form', 'method' => 'PATCH','enctype'=>"multipart/form-data"]) }}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Video</h3>

            <div class="box-tools pull-right">
                @include('backend.access.homepageVideo.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('URL','URL', ['class' => 'col-lg-2 control-label']) }}
                <input type="hidden" name="id" value="{{$brand->id}}">
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="url" value="{{$brand->url}}" placeholder="Enter video URL">
                </div><!--col-lg-10-->
            </div>

        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-success">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.homepagevideo.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
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
    @include('backend.access.influencer.includes.partials.youtube-api')

@endsection
