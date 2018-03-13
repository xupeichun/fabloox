@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management'))

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>
        VigLink Products
    </h1>
@endsection

@section('content')

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">All Products</h3>

            <div class="box-tools pull-right">
                @include('backend.access.product2.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="overlay" id="the_loader" >
                <div class="loader"></div>
            </div>
            <form class="form-inline">
                <div class="row" style="margin-bottom: 5px">

                    <div class="form-group col-md-3">
                        <label for="keyword">Keyword:</label>
                        <input type="text" class="form-control" id="keyword">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cat">Category:</label>
                        <input type="text" class="form-control" id="cat">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cat">Brand:</label>
                        <input type="text" class="form-control" id="brand">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Show <select name="users-table_length" id="max" aria-controls="users-table" class="form-control input-sm">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> entries</label>
                        <input type="button" class="btn btn-default search_button pull-right" value="Search"/>

                    </div>

                </div>
                <div class="row">

                </div>
            </form>
            <div class="table-responsive">

                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>


                        <th width="10%">Image</th>
                        {{--
                        <th>Product ID</th>
--}}
                        <th width="20%">Name</th>
                        <th width="20%">Category</th>
                        <th width="10%">Price</th>
                        <th width="20%">Merchant Name</th>
                        <th width="20%">Best on Fabloox</th>
                        <th width="10%">Actions</th>

                    </tr>
                    </thead>
                    <tbody class="table_body">

                    </tbody>
                </table>
                <ul id="pagination-demo" class="pagination-sm"></ul>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

@endsection

@section('after-scripts')
    {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    @include('backend.access.product2.includes.partials.fabloox-products')
@endsection
