@extends ('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Brand Video
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.brandVideos.store', 'files' => true]) !!}
                        @include('admin.brand_videos.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
