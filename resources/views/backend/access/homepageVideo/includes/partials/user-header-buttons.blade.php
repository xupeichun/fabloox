<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.access.homepagevideo.index','All Videos', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.access.homepagevideo.create','Add Video', [], ['class' => 'btn btn-success btn-xs']) }}
    {{ link_to_route('admin.access.homepagevideo.deactivated','Deactivated', [], ['class' => 'btn btn-warning btn-xs']) }}

</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('menus.backend.access.users.main') }} <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            {{ link_to_route('admin.access.homepagevideo.index','All Videos') }}
            {{ link_to_route('admin.access.homepagevideo.create','Add Video') }}
            {{ link_to_route('admin.access.homepagevideo.deactivated','Deactivated') }}

        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>