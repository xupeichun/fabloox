@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management'))

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>
        Gallery Management
        <small>Add images to display on the homepage gallery</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Active Gallery</h3>

            <div class="box-tools pull-right">
                @include('backend.access.gallery.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('labels.backend.access.users.table.id') }}</th>
                       {{-- <th>Image</th>--}}
                        <th>Image</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>{{ trans('labels.general.actions') }}</th>

                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

@endsection

@section('after-scripts')
    {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}

    <script>
        $(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.access.gallery.get") }}',
                    type: 'post',
                    data: {status: 1, trashed: false}
                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'images', name: 'images'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'action', name: 'action', searchable: false, sortable: false},
//                    {data: 'extra', name: 'extra', searchable: false, sortable: false}

                ],
                order: [[0, "asc"]],
                searchDelay: 500
            });
        });
    </script>

    <script>
        $(document).delegate(".deactivateButton", "click", function () {
            var id = $(this).data('id');
            console.log('sd')

            swal({
                title: 'Are you sure you want to deactivate?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }, function () {

                $.ajax({
                    url: "{{ route("admin.access.gallery.deactivateItem") }}",
                    data: {id: id},
                    type: 'DELETE',


                }).done(function () {
                    $('#cat-deactivate-' + id).closest('tr').remove();
                });
            })
        });

        $("table").delegate(".deleteButton", "click", function () {
            var id = $(this).data('id');


            swal({
                title: 'Are you sure you want to delete?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }, function () {

                $.ajax({
                    url: "{{ url("admin/access/gallery") }}/" + id,
                    type: 'DELETE',


                }).done(function () {
                    $('#cat-delete-' + id).closest('tr').remove();

                });
            })
        })
    </script>
@endsection
