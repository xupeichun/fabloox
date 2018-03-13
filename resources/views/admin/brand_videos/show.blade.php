@extends ('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Brand Video
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.brand_videos.show_fields')
                    <a href="{!! route('admin.brandVideos.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
