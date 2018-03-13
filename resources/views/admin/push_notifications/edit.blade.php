@extends ('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Push Notification
        </h1>
   </section>
   <div class="content">

       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($pushNotification, ['route' => ['admin.pushNotifications.update', $pushNotification->id], 'method' => 'patch']) !!}

                        @include('admin.push_notifications.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
    <script>
        $(document).ready(function () {
            $('#start_datetimepicker').datetimepicker({
                sideBySide:true,
                format: 'YYYY-MM-DD HH:mm:ss',
                ignoreReadonly: true,
            });
        })

    </script>
@endsection