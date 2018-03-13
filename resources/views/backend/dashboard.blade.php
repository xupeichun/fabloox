@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}

    </h1>
    {{--
        {{dd($favourite)}}
    --}}
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="loader" style="display: none;">
            <div class="ajax-spinner ajax-skeleton"></div>
        </div>
        <!--loader-->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$users}}</h3>

                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.access.user.index') }}" class="small-box-footer">More info <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3> Analytics</h3>

                        <p>Flurry Analytics</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="https://developer.yahoo.com/analytics/" target="_blank" class="small-box-footer">More info
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>

            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>23</h3>

                        <p>Favorites</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <div href="#" class="small-box-footer" style="background: transparent;height: 25px">
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                {{--                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h3>33</h3>

                                            <p>Parents</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-pie-graph"></i>
                                        </div>
                                        <a href="{{ url('admin/user') }}" class="small-box-footer">More info <i
                                                    class="fa fa-arrow-circle-right"></i></a>
                                    </div>--}}
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Recent Users Added</h3>

                        <div class="box-tools pull-right">
                        </div><!--box-tools pull-right-->
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            @foreach($latestusers as $user)
                                <li class="item">
                                    <div class="product-img">

                                        @if(isset($user->avatar) && strpos($user->avatar,'inf_img') !== false)
                                            <img src="{{$user->avatar}}" alt="Product Image ok">
                                        @else
                                            <img src="{{access()->user()->picture}}" alt="Product Image">
                                        @endif
                                    </div>
                                    <div class="product-info">
                                        <a href="{{url('/admin/access/user')}}/{{$user->id}}"
                                           class="product-title">{{$user->name}}
                                        </a>
                                        <span class="product-description">
                                        has joined Fabloox on {{date('d-M-Y',strtotime($user->created_at))}}
                                    </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div><!--tab panel-->

                </div><!-- /.box-body -->
            </div><!--box-->
            <div class="col-lg-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Recent Products Added to Favorites by Users</h3>

                        <div class="box-tools pull-right">
                        </div><!--box-tools pull-right-->
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <ul class="products-list product-list-in-box">

                            @foreach($favourite as $fav)
                                @if(isset($fav->user))
                                    <li class="item">
                                        <div class="product-img">
                                            @if($fav->image)
                                                <img src="{{$fav->image}}" alt="Image">
                                            @else
                                                {{--
                                                                                            <img src="{{access()->user()->picture}}" alt="Product Image">
                                                --}}
                                            @endif
                                        </div>
                                        <div class="product-info">
                                            <a href="{{url('/admin/access/user')}}/{{$fav->user->id ? $fav->user->id: ""}}"
                                               class="product-title">{{$fav->user->name ? $fav->user->name : "" }}
                                            </a>
                                            <p class="product-description"
                                               style="word-break: break-word;white-space:unset">
                                                has added "{{$fav->productName}}" to favorites.
                                            </p>
                                        </div>
                                    </li>
                                @endif

                            @endforeach
                        </ul>

                    </div><!--tab panel-->

                </div><!-- /.box-body -->
            </div>
        </div>


        </div>


    </section>
    <!-- /.content -->
@endsection