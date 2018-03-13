<table class="table table-striped table-hover">
    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.avatar') }}</th>
        <td>

            @if(strpos($user->avatar,'inf_img') !== false)
            <img src="{{$user->avatar}}" class="user-profile-image img-responsive" width="30%" /></td>
            @else
            <img src="{{ $user->picture }}" class="user-profile-image" /></td>
            @endif
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.name') }}</th>
        <td>{{ $user->name }}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.email') }}</th>
        <td>{{ $user->email }}</td>
    </tr>

    <tr>
        <th>Username</th>
        <td>{{ $user->username }}</td>
    </tr>

    <tr>
        <th>Gender</th>
        <td>{{ $user->gender }}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.status') }}</th>
        <td>{!! $user->status_label !!}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.confirmed') }}</th>
        <td>{!! $user->confirmed_label !!}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.created_at') }}</th>
        <td>{{ $user->created_at }} ({{ $user->created_at->diffForHumans() }})</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.last_updated') }}</th>
        <td>{{ $user->updated_at }} ({{ $user->updated_at->diffForHumans() }})</td>
    </tr>

    @if ($user->trashed())
        <tr>
            <th>{{ trans('labels.backend.access.users.tabs.content.overview.deleted_at') }}</th>
            <td>{{ $user->deleted_at }} ({{ $user->deleted_at->diffForHumans() }})</td>
        </tr>
    @endif
</table>