@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
    <h1>
        Content Management
        <small>Terms & Conditions</small>
    </h1>
@endsection
@section('content')
    <!-- Main content -->

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ route('admin.access.content.addTerms') }}" class="form-horizontal"
                  enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">CK Editor
                            <small>Advanced and full of features</small>
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-info btn-sm" data-widget="collapse"
                                    data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="box-body pad">
                        <form>
                            <textarea id="editor1" name="terms" rows="10"
                                      cols="80">@if(isset($data)){{$data}} @endif</textarea>
                        </form>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{{url('admin/dashboard')}}" class="btn btn-default">Cancel</a>
                            <input class="btn btn-success btn-md" type="submit" value="Save">
                        </div>
                    </div>

                </div>
                <!-- /.box -->

            </form>
        </div>
        <!-- /.col-->
    </div>
    <!-- ./row -->

    <!-- /.content -->
    <script>
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
//            CKEDITOR.replace('editor1');
            //bootstrap WYSIHTML5 - text editor
            /*$('.textarea').wysihtml5()*/
        })
    </script>
@endsection

@section('after-scripts')
    {{ Html::script('js/backend/access/users/script.js') }}
@endsection
