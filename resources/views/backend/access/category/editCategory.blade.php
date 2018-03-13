@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
    <h1>
        Category Management
    </h1>
@endsection

@section('content')


    {{ Form::open(['route' => ['admin.access.category.update',$cat->id],  'class' => 'form-group form-horizontal', 'role' => 'form', 'method' => 'PATCH','enctype'=>"multipart/form-data"]) }}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Category</h3>

            <div class="box-tools pull-right">
                @include('backend.access.category.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('Category','Category', ['class' => 'col-lg-2 control-label']) }}
                <input type="hidden" name="id" value="{{$cat->id}}">
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="categoryName" value="{{$cat->categoryName}}">
                </div><!--col-lg-10-->
            </div><!--form control-->
            <div class="form-group">
                {{ Form::label('Keyword', 'Keyword', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('keyword', $cat->keyword, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Keyword']) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('Order No', 'Order No', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::number('sort_id', $cat->sort_id, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Order No']) }}
                </div><!--col-lg-10-->
            </div><!--form control-->
            <div class="form-group">
                {{ Form::label('Featured', 'Featured', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <input type="checkbox" name="featured" value="0" {{ $cat->featured == 1 ?  'checked':''}} style="visibility:hidden">
                    <input type="checkbox" name="featured" value="1" {{ $cat->featured == 1 ?  'checked':''}}>
                </div><!--col-lg-10-->
            </div><!--form control-->
            <div class="form-group">
                {{ Form::label('Image', 'Image', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-6">
                    <input type="file"  name="image">
                    <input type="hidden"  name="img_status" value="exist">

                </div><!--col-lg-10-->
                <div class="col-lg-4">
                    <img class="img-responsive" src="{{asset('/')}}/{{$cat->image}}" alt="">
                </div><!--col-lg-10-->
            </div>
        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-success">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.category.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
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
