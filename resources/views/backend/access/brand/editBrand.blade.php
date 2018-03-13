@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
    <h1>
       Brands Management
    </h1>
@endsection

@section('content')


    {{ Form::open(['route' => ['admin.access.brand.update',$brand->id],  'class' => 'form-group form-horizontal', 'role' => 'form', 'method' => 'PATCH','enctype'=>"multipart/form-data"]) }}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Brand</h3>

            <div class="box-tools pull-right">
                @include('backend.access.brand.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('Brand','Brand', ['class' => 'col-lg-2 control-label']) }}
                <input type="hidden" name="id" value="{{$brand->id}}">
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="brandName" value="{{$brand->brandName}}" placeholder="Brand Name">
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('Merchant ID', 'Merchant ID', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('merchant_id', $brand->merchant_id, ['class' => 'form-control', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Merchant ID']) }}
                </div><!--col-lg-10-->
            </div><!--form control-->
            <div class="form-group">
                {{ Form::label('Order No.', 'Order No.', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::number('sort_no', $brand->sort_no, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Order No.']) }}
                </div><!--col-lg-10-->
            </div><!--form control-->
            <div class="form-group">
                {{ Form::label('Detail', 'Detail', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <textarea name="detail" id="" class="form-control" placeholder="Brand detail">{{$brand->detail}}</textarea>
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('Logo', 'Logo', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-6">
                    <input type="file"  name="logo">
                    <input type="hidden"  name="img_status" value="{{$brand->logo? 'exit':'notExist'}}">
                </div><!--col-lg-10-->

                <div class="col-lg-4">
                    <img class="img-responsive" src="{{asset('/')}}/{{$brand->logo}}" alt="">
                </div><!--col-lg-10-->
            </div>

        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-success">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.brand.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
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


@endsection
