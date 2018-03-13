@extends ('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            FAQs
        </h1>
    </section>
    <div class="content">

        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.faqs.store']) !!}

                        @include('admin.faqs.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
