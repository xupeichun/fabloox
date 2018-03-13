@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.deactivated'))

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>
        Category Management
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Deactivated Categories</h3>

            <div class="box-tools pull-right">
                @include('backend.access.category.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.access.users.table.id') }}</th>
                            <th>Name</th>
                            <th>keyword</th>
                            <th>Order</th>
                            <th>Featured</th>
                            <th>Image</th>
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
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.access.category.deactivate") }}',
                    type: 'post',
                    data: {status: 0, trashed: false}
                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'categoryName', name: 'categoryName'},
                    {data: 'keyword', name: 'keyword'},
                    {data: 'sort_id', name: 'sort_id'},
                    {data: 'featured', name: 'featured'},
                    {data: 'image', name: 'image'},
                    {data: 'action', name: 'action', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500
            });
        });
    </script>
    <script>
        $(document).delegate(".activateButton", "click", function () {
            var id = $(this).data('id');
            console.log('sd')

            swal({
                title: 'Are you sure you want to activate?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }, function () {

                $.ajax({
                    url: "{{ route("admin.access.category.activateCategory") }}",
                    data: {id: id},
                    type: 'get',


                }).done(function () {
                    $('#cat-activate-' + id).closest('tr').remove();
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
                    url: "{{ url("admin/access/category") }}/" + id,
                    type: 'DELETE',


                }).done(function () {
                    $('#cat-delete-' + id).closest('tr').remove();

                });
            })
        })
    </script>
@endsection
