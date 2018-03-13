<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.access.product.index','Rakuten Products', [], ['class' => 'btn btn-primary btn-xs']) }}

    {{ link_to_route('admin.access.product.get.index2','VigLink Products', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.access.product.show.best','Best on Fabloox', [], ['class' => 'btn btn-info btn-xs']) }}
    {{ link_to_route('admin.access.product.list.gallery.products','Gallery products', [], ['class' => 'btn btn-success btn-xs']) }}

    {{--{{ link_to_route('admin.access.influencer.create','Create Influencer', [], ['class' => 'btn btn-success btn-xs']) }}--}}
    {{ link_to_route('admin.access.product.deactivated','Deactivated', [], ['class' => 'btn btn-warning btn-xs']) }}

</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('menus.backend.access.users.main') }} <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            {{ link_to_route('admin.access.influencer.index','All Influencer') }}
           {{-- {{ link_to_route('admin.access.influencer.create','Create Influencer') }}--}}
            {{ link_to_route('admin.access.influencer.deactivated','Deactivated') }}

        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>