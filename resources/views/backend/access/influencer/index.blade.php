@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management'))

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>
        Influencers Management
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Active Influencers</h3>

            <div class="box-tools pull-right">
                @include('backend.access.influencer.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        {{--<th>{{ trans('labels.backend.access.users.table.id') }}</th>--}}
                       {{-- <th>Image</th>--}}
                        {{--<th>Name</th>--}}
                        <th width="5%">Id</th>
                        <th width="10%">Name</th>
                        <th  width="35%">Description</th>
                        <th  width="10%">Order</th>
                        <th  width="20%">Channel Name</th>

                        <th  width="20%">{{ trans('labels.general.actions') }}</th>

                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->


@endsection

@section('after-scripts')
    {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    @include('backend.access.influencer.includes.partials.vidoesLink')

@endsection
