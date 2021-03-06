@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
    <h1>
        Influencers Management
    </h1>
@endsection

@section('content')

    {{ Form::open(['route' => ['admin.access.influencer.update',$brand->id],  'class' => 'form-group form-horizontal', 'role' => 'form', 'method' => 'PATCH','enctype'=>"multipart/form-data"]) }}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Influencer</h3>

            <div class="box-tools pull-right">
                @include('backend.access.influencer.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('Influencer','Influencer', ['class' => 'col-lg-2 control-label']) }}
                <input type="hidden" name="id" value="{{$brand->id}}">
                <input type="hidden" id="channel_name" name="channel_name" value="{{$brand->channel_name}}">

                <div class="col-lg-10">
                    <input type="text" class="form-control" name="influencerName" value="{{$brand->influencerName}}" placeholder="Brand Name">
                </div><!--col-lg-10-->
            </div>
            <div class="form-group">
                {{ Form::label('Order No.', 'Order No.', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::number('order', $brand->order, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Order No.']) }}
                </div><!--col-lg-10-->
            </div>
            <!--form control-->
            <div class="form-group">
                {{ Form::label('Search', 'Search', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-6">
                    {{ Form::text('keyword', $brand->channel_name, ['class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => 'Keyword for channel','id'=>"keyword"]) }}
                </div><!--col-lg-10-->

                <div class="col-lg-4">
                    <input type="button" class="btn btn-md btn-info channel_search" value="search"/>
                </div><!--col-lg-10-->
                <div class="col-lg-offset-2" style="padding-left: 15px">
                    <input type="hidden" name="channel" required id="channel" value="{{$brand->channel}}">
                    <p style="display: none" class="para"><span class="channleName" > </span> has been added <i class="fa fa-times cross" aria-hidden="true"></i></p>
                </div>

            </div><!--form control-->

            <!--form control-->
            <div class="form-group">
                {{ Form::label('Description', 'Description', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">

                    {{ Form::textarea('description', $brand->description, ['class' => 'form-control', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Description']) }}

                </div><!--col-lg-10-->
            </div><!--form control-->

            <!--form control-->
            <div class="form-group">
                {{ Form::label('Image', 'Image', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-5">
                    <input type="file" name="image">
                    <input type="hidden"  name="img_status" value="{{$brand->image ? 'exit':'notExist'}}">

                </div><!--col-lg-10-->
                <div class="col-lg-5">
                    <img class="img-responsive" src="{{asset('/uploads/influencerimages')}}/{{$brand->image}}" alt="">
                </div><!--col-lg-10-->
            </div><!--form control-->

        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-success">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.influencer.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
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
