<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('menus.backend.sidebar.general') }}</li>

            <li class="{{ active_class(Active::checkUriPattern('admin/dashboard')) }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ trans('menus.backend.sidebar.dashboard') }}</span>
                </a>
            </li>

            <li class="header">{{ trans('menus.backend.sidebar.system') }}</li>


            @role(1)
            <li class="{{ active_class(Active::checkUriPattern('admin/access/user/*')) }} {{ active_class(Active::checkUriPattern('admin/access/role/*')) }}  {{ active_class(Active::checkUriPattern('admin/access/user')) }} {{ active_class(Active::checkUriPattern('admin/access/role')) }}  treeview">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span>{{ trans('menus.backend.access.title') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/user/*'), 'menu-open') }} {{ active_class(Active::checkUriPattern('admin/access/role/*'), 'menu-open') }} {{ active_class(Active::checkUriPattern('admin/access/user'), 'menu-open') }} {{ active_class(Active::checkUriPattern('admin/access/role'), 'menu-open') }}"
                    style="display: none; {{ active_class(Active::checkUriPattern('admin/access/user/*'), 'display: block;') }} {{ active_class(Active::checkUriPattern('admin/access/role/*'), 'display: block;') }} {{ active_class(Active::checkUriPattern('admin/access/user'), 'display: block;') }} {{ active_class(Active::checkUriPattern('admin/access/role'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/user')) }} {{ active_class(Active::checkUriPattern('admin/access/user/*')) }}">
                        <a href="{{ route('admin.access.user.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('labels.backend.access.users.management') }}</span>
                        </a>
                    </li>

                    {{--                    <li class="{{ active_class(Active::checkUriPattern('admin/access/role')) }} {{ active_class(Active::checkUriPattern('admin/access/role/*')) }}">
                                            <a href="{{ route('admin.access.role.index') }}">
                                                <i class="fa fa-circle-o"></i>
                                                <span>{{ trans('labels.backend.access.roles.management') }}</span>
                                            </a>
                                        </li>--}}
                </ul>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/access/category/*')) }} {{ active_class(Active::checkUriPattern('admin/access/brand/*')) }} {{ active_class(Active::checkUriPattern('admin/access/product/*')) }} {{ active_class(Active::checkUriPattern('admin/access/category')) }} {{ active_class(Active::checkUriPattern('admin/access/brand')) }} {{ active_class(Active::checkUriPattern('admin/access/product')) }}  treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Product Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu  {{ active_class(Active::checkUriPattern('admin/access/category/*'), 'menu-open') }} {{ active_class(Active::checkUriPattern('admin/access/brand/*'), 'menu-open') }} {{ active_class(Active::checkUriPattern('admin/access/product/*'), 'menu-open') }}"
                    style="display: none; {{ active_class(Active::checkUriPattern('admin/access/category'), 'display: block;') }} {{ active_class(Active::checkUriPattern('admin/access/category/*'), 'display: block;') }}{{ active_class(Active::checkUriPattern('admin/access/brand'), 'display: block;') }} {{ active_class(Active::checkUriPattern('admin/access/brand/*'), 'display: block;') }} {{ active_class(Active::checkUriPattern('admin/access/product'), 'display: block;') }} {{ active_class(Active::checkUriPattern('admin/access/product/*'), 'display: block;') }}  ">
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/category')) }} {{ active_class(Active::checkUriPattern('admin/access/category/*')) }}">
                        <a href="{{ route('admin.access.category.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Categories</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/brand')) }} {{ active_class(Active::checkUriPattern('admin/access/brand/*')) }} ">
                        <a href="{{ route('admin.access.brand.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Brands</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/product')) }} {{ active_class(Active::checkUriPattern('admin/access/product/deactivated')) }} {{ active_class(Active::checkUriPattern('admin/access/product/galleryproducts/list')) }} {{ active_class(Active::checkUriPattern('admin/access/product/bestonfabloox')) }} {{ active_class(Active::checkUriPattern('admin/access/product/editlinks/*')) }}  ">
                        <a href="{{ route('admin.access.product.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Rakuten Products</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/product/viglink')) }}">
                        <a href="{{ route('admin.access.product.get.index2') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>VigLink Products</span>
                        </a>
                    </li>


                </ul>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/access/influencer/*')) }} {{ active_class(Active::checkUriPattern('admin/access/influencer')) }} "><a
                        href="{{ route('admin.access.influencer.index') }}"><i class="fa fa-book"></i>
                    <span>Influencers</span></a></li>
            <li class="{{ active_class(Active::checkUriPattern('admin/access/homepagevideo')) }} {{ active_class(Active::checkUriPattern('admin/access/homepagevideo/*')) }} "><a
                        href="{{ route('admin.access.homepagevideo.index') }}"><i class="fa fa-youtube"></i> <span>Home Videos</span></a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/access/gallery')) }} {{ active_class(Active::checkUriPattern('admin/access/gallery/*')) }} "><a
                        href="{{ route('admin.access.gallery.index') }}"><i class="fa fa-picture-o"></i> <span>Home Gallery</span></a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/pushNotifications')) }} {{ active_class(Active::checkUriPattern('admin/pushNotifications/*')) }} ">
                <a href="{{ route('admin.pushNotifications.index') }}">
                    <i class="fa fa-bell"></i>
                    <span>Push Notifications</span>
                </a>
            </li>



            <li class="{{ active_class(Active::checkUriPattern('admin/access/content/*')) }} treeview {{ active_class(Active::checkUriPattern('admin/faqs')) }} ">
                <a href="#">
                    <i class="fa fa-pencil-square-o"></i>
                    <span>Content Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
{{--{{ active_class(Active::checkUriPattern('admin/access/content/*'), 'menu-open') }}
{{ active_class(Active::checkUriPattern('admin/access/content/*'), 'display: block;') }}
--}}
                <ul class="treeview-menu">
                    <li class="treeview {{ active_class(Active::checkUriPattern('admin/access/content/*')) }}">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>

                            <span>About</span>
                            <i class="fa fa-angle-left pull-right"></i>

                        </a>
                        <ul class="treeview-menu  " style="display: @if( Request::url()  == url('admin/access/content/policy') ) block @endif  @if( Request::url()  == url('admin/access/content/terms') ) block @endif @if( Request::url()  == url('admin/access/content/info') ) block @endif  " >
                            <li class=" treeview  {{ active_class(Active::checkUriPattern('admin/access/content/policy')) }}">
                                <a href="{{ route('admin.access.content.policy') }}">
                                    {{--<i class="fa fa-circle-o"></i>--}}
                                    <span>Privacy Policy</span>
                                </a>
                            </li>
                            <li class=" treeview {{ active_class(Active::checkUriPattern('admin/access/content/terms')) }}">
                                <a href="{{ route('admin.access.content.terms') }}">
                                    {{--<i class="fa fa-circle-o"></i>--}}
                                    <span>Terms & Conditions</span>
                                </a>
                            </li>


                            <li class="{{ active_class(Active::checkUriPattern('admin/access/content/info')) }}">
                                <a href="{{ route('admin.access.content.info') }}">
                                    {{--<i class="fa fa-circle-o"></i>--}}
                                    <span>Info</span>
                                </a>
                            </li>
                        </ul>


                    </li>


                    {{--<li class="{{ active_class(Active::checkUriPattern('admin/mockResonses*')) }}">--}}
                    {{--<a href="{{ route('admin.mockResonses.index') }}">--}}
                    {{--<i class="fa fa-circle-o"></i>--}}
                    {{--<span>Mock Responses</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    <li class="{{ active_class(Active::checkUriPattern('admin/faqs')) }}">
                        <a href="{{ route('admin.faqs.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>FAQs</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth
        </ul><!-- /.sidebar-menu -->
    </section><!-- /.sidebar -->
</aside>
