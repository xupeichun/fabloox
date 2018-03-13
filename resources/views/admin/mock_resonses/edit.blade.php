@extends ('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Mock Resonse
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($mockResonse, ['route' => ['admin.mockResonses.update', $mockResonse->id], 'method' => 'patch']) !!}

                        @include('admin.mock_resonses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection