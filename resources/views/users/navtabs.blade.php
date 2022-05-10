<ul class="nav nav-tabs nav-justified mb-3">
    {{-- ユーザ詳細タブ --}}
    <li class="nav-item">
        <a href="{{ route('users.show', ['user' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
            Timeline
            <span class="badge badge-secondary">{{ $user->microposts_count }}</span>
        </a>
    </li>
    
    {{-- フォロー一覧タブ --}}
    <li class="nav-item">
        <a href="{{ route('user.followings', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('user.followings') ? 'active' : '' }}">
            Followings
            <span class="badge badge-secondary">{{ $user->followings_count }}</span>
        </a>
    </li>
    
    {{-- フォロワー一覧タブ --}}
    <li class="nav-item">
        <a href="{{ route('user.followers', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('user.followers') ? 'active' : '' }}">
            Followers
            <span class="badge badge-secondary">{{ $user->followers_count }}</span>
        </a>
    </li>
    
</ul>