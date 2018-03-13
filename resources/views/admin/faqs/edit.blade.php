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
                   {!! Form::model($faqs, ['route' => ['admin.faqs.update', $faqs->id], 'method' => 'patch']) !!}

                        @include('admin.faqs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection