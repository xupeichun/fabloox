@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.deactivated'))

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>
        Product Management
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Gallery Products</h3>

            <div class="box-tools pull-right">
                @include('backend.access.product.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gallery Image</th>
                        <th>Product Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Merchant Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($result))
                        @foreach($result as $data)
                            <tr>
                                <td>{{++$loop->index}}</td>
                                <td><img src="{{asset($data->gallery_image)}}" alt="" width="100"></td>
                                <td><img src="{{$data->image}}" alt="" width="50"></td>
                                <td>{{$data->productName}}</td>
                                <td>{{$data->categoryName}}</td>
                                <td>{{$data->merchant_name}}</td>
                                <td>
                                    <button class="btn btn-xs btn-danger delete_best_on_fab"
                                            data-id="{{$data->id}}"><i
                                                class="glyphicon glyphicon-trash"></i> Delete
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}

    <script>
        $('.delete_best_on_fab').on("click", function () {
            var removeButton = $(this);
            var id = $(this).data('id');
            console.log(id)

            swal({
                title: 'Are you sure you want to delete?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }, function (state) {
                if (state == true) {

                    $.ajax({
                        url: "{{ route("admin.access.product.gallery.remove") }}",
                        data: {
                            'id': id,
                        },
                        type: 'POST',


                    }).done(function (data) {
                        if (data.status == 200) {
                            removeButton.closest('tr').remove();
                        } else if (data.status == 401) {
                        } else if (data.status == 500) {
                        }
                    });
                }
            })
        });

    </script>
@endsection
