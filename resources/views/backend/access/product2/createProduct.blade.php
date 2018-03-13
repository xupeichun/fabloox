@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.create'))

@section('page-header')
    <h1>
        Influencer Management
        <small>Create Influencer</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.access.product.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','enctype'=>"multipart/form-data"]) }}

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Create Influencer</h3>

            <div class="box-tools pull-right">
                @include('backend.access.influencer.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('Name', 'Name', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('influencerName', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Influencer Name']) }}
                </div><!--col-lg-10-->
            </div>

            <!--form control-->
            <div class="form-group">
                {{ Form::label('Search', 'Search', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-6">
                    {{ Form::text('keyword', null, ['class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => 'keyword for channel','id'=>"keyword"]) }}
                </div><!--col-lg-10-->

                <div class="col-lg-4">
                    <input type="button" class="btn btn-md btn-info channel_search" value="search"></input>
                </div><!--col-lg-10-->
                <div class="col-lg-offset-2" style="padding-left: 15px">
                    <input type="hidden" name="channel" required id="channel">
                    <p style="display: none" class="para"><span class="channleName" > </span> has been added <i class="fa fa-times cross" aria-hidden="true"></i></p>
                </div>

            </div><!--form control-->

            <!--form control-->
            <div class="form-group">
                {{ Form::label('Description', 'Description', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::textarea('description', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Description']) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <!--form control-->
            <div class="form-group">
                {{ Form::label('image', 'image', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <input type="file"  name="image">
                </div><!--col-lg-10-->
            </div><!--form control-->


        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-info">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.brand.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
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
    @include('backend.access.influencer.includes.partials.youtube-api')

@endsection
