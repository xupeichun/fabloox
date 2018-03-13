<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Subject', 'Subject:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Detail Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('Description', 'Description:') !!}
    {!! Form::textarea('detail', null, ['class' => 'form-control']) !!}
</div>

<!-- Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Date and Time', 'Date and Time') !!}
    {{--
        {!! Form::date('time', null, ['class' => 'form-control']) !!}
    --}}
    <div class='input-group date' id="start_datetimepicker">
        {!! Form::text('time', null, ['class' => 'form-control']) !!}

        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary', 'onClick'=>"var e=this;setTimeout(function(){e.disabled=true;},0);return true;"]) !!}
    <a href="{!! route('admin.pushNotifications.index') !!}" class="btn btn-default">Cancel</a>
</div>

