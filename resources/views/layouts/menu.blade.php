<li class="{{ Request::is('mockResonses*') ? 'active' : '' }}">
    <a href="{!! route('admin.mockResonses.index') !!}"><i class="fa fa-edit"></i><span>Mock Resonses</span></a>
</li>

<li class="{{ Request::is('pushNotifications*') ? 'active' : '' }}">
    <a href="{!! route('admin.pushNotifications.index') !!}"><i class="fa fa-edit"></i><span>Push Notifications</span></a>
</li>

<li class="{{ Request::is('pushNotifications*') ? 'active' : '' }}">
    <a href="{!! route('admin.pushNotifications.index') !!}"><i class="fa fa-edit"></i><span>Push Notifications</span></a>
</li>

<li class="{{ Request::is('brandVideos*') ? 'active' : '' }}">
    <a href="{!! route('admin.brandVideos.index') !!}"><i class="fa fa-edit"></i><span>Brand Videos</span></a>
</li>

<li class="{{ Request::is('faqs*') ? 'active' : '' }}">
    <a href="{!! route('admin.faqs.index') !!}"><i class="fa fa-edit"></i><span>Faqs</span></a>
</li>

