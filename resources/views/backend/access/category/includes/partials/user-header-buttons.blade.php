<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.access.category.index','All Categories', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.access.category.create','Create Category', [], ['class' => 'btn btn-success btn-xs']) }}
    {{ link_to_route('admin.access.category.deactivated','Deactivated', [], ['class' => 'btn btn-warning btn-xs']) }}

</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('menus.backend.access.users.main') }} <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            {{ link_to_route('admin.access.category.index','All Categories') }}
            {{ link_to_route('admin.access.category.create','Create Category') }}
            {{ link_to_route('admin.access.category.deactivated','Deactivated') }}
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>