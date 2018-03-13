@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.users.management') }}
        <small>{{ trans('labels.backend.access.users.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.access.user.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','enctype'=>"multipart/form-data"]) }}

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.access.users.create') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.access.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('first_name', trans('validation.attributes.backend.access.users.first_name'), ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('first_name', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.access.users.first_name')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('last_name', trans('validation.attributes.backend.access.users.last_name'),
                 ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('last_name', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'placeholder' => trans('validation.attributes.backend.access.users.last_name')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->
            <div class="form-group">
                {{ Form::label('username','Username',
                 ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('username', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'placeholder' => 'USERNAME']) }}
                </div><!--col-lg-10-->
            </div><!--form control-->
            <div class="form-group">
                {{ Form::label('Gender','Gender',
                 ['class' => 'col-lg-2 control-label']) }}

                <div class="col-xs-5">
                    {{ Form::select('gender', ['male' => 'Male', 'female' => 'Female'], 'male',['class' => 'form-control']) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('email', trans('validation.attributes.backend.access.users.email'), ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::email('email', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'placeholder' => trans('validation.attributes.backend.access.users.email')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('password', trans('validation.attributes.backend.access.users.password'), ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('validation.attributes.backend.access.users.password')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('password_confirmation', trans('validation.attributes.backend.access.users.password_confirmation'), ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('validation.attributes.backend.access.users.password_confirmation')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->
            <div class="form-group">
                {{ Form::label('Image', "Image", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <input type="file" name="image">
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                <label class="col-lg-2 control-label">Active
                    <br/>
                    <small>(If a user is not active, s/he will not have access to the account)</small>
                </label>
                <div class="col-lg-1">
                    {{ Form::checkbox('status', '1', true) }}

                </div><!--col-lg-1-->
            </div><!--form control-->

            <div class="form-group">
                <label class="col-lg-2 control-label">Confirmed
                    <br/>
                    <small>(If a user is not confirmed, s/he will receive an email for account confirmation)</small>
                </label>
                <div class="col-lg-1">
                    {{ Form::checkbox('confirmed', '1', true,['class'=>'confirm']) }}
                </div><!--col-lg-1-->
            </div><!--form control-->

            <div class="form-group">
                <label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.access.users.send_confirmation_email') }}
                    <br/>
                    <small>(If user is not confirmed)</small>
                </label>

                <div class="col-lg-1">
                    {{ Form::checkbox('confirmation_email', '1',false,['class'=>'econfirm']) }}
                </div><!--col-lg-1-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('associated_roles', trans('validation.attributes.backend.access.users.associated_roles'), ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-3">
                    @if (count($roles) > 0)
                        @foreach($roles as $role)
                            <input class="theRoles" type="checkbox" value="{{ $role->id }}"
                                   name="assignees_roles[{{ $role->id }}]"
                                   id="role-{{ $role->id }}" {{ is_array(old('assignees_roles')) && in_array($role->id, old('assignees_roles')) ? 'checked' : '' }} />
                            <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                            <a href="#" data-role="role_{{ $role->id }}" class="show-permissions small">
                                (<span class="show-text">{{ trans('labels.general.show') }}</span>
                                <span class="hide-text hidden">{{ trans('labels.general.hide') }}</span>
                                {{ trans('labels.backend.access.users.permissions') }})
                            </a>
                            <br/>
                            <div class="permission-list hidden" data-role="role_{{ $role->id }}">
                                @if ($role->all)
                                    {{ trans('labels.backend.access.users.all_permissions') }}<br/><br/>
                                @else
                                    @if (count($role->permissions) > 0)
                                        <blockquote class="small">{{--
                                        --}}@foreach ($role->permissions as $perm){{--
                                            --}}{{$perm->display_name}}<br/>
                                            @endforeach
                                        </blockquote>
                                    @else
                                        {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
                                    @endif
                                @endif
                            </div><!--permission list-->
                        @endforeach
                    @else
                        {{ trans('labels.backend.access.users.no_roles') }}
                    @endif
                </div><!--col-lg-3-->
            </div><!--form control-->
        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-info">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.user.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
            </div><!--pull-left-->

            <div class="pull-right">
                {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-xs']) }}
            </div><!--pull-right-->

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->

    {{ Form::close() }}
@endsection

@section('after-scripts')
    {{ Html::script('js/backend/access/users/script.js') }}
    <script>
        $('.theRoles').click(function () {
            $(this).siblings('input:checkbox').prop('checked', false);
        });
        $('.confirm').click(function () {
            $(this).closest('.box-body').find('.econfirm').prop('checked', false);
        });
        $('.econfirm').click(function () {
            $(this).closest('.box-body').find('.confirm').prop('checked', false);
        });
    </script>
@endsection
