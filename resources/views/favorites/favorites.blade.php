@if(count($favorites) > 0)
    <ul class="list-unstyled">
        @foreach($favorites as $favorite)
            <li class="media mb-3">
                <img class="mr-2 rounded" src="{{ Gravatar::get($favorite->user->email, ['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{--　投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show', $favorite->user->name, ['user' => $favorite->user->id]) !!}
                        <span class="text-muted">posted at {{ $favorite->created_at }}</span>
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($favorite->content)) !!}</p>
                    </div>
                    <div class="d-flex">
                        {{-- お気に入りに追加しているポストであればお気に入り削除ボタンを表示 --}}
                        @if (Auth::user()->is_favorite($favorite->id))
                            {!! Form::open(['route' => ['favorites.unfavorite', $favorite->id], 'method' => 'delete']) !!}
                                {!! Form::submit('Unfavorite', ['class' => 'btn btn-success btn-sm m-1']) !!}
                            {!! Form::close() !!}
                        @endif
                        {{-- 自分自身のポストであれば削除ボタンを表示 --}}
                        @if (Auth::id() == $favorite->user_id)
                            {!! Form::open(['route' => ['microposts.destroy', $favorite->id], 'method' => 'delete']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm m-1']) !!}
                            {!! Form::close() !!}
                        @endif
    
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $favorites->links() }}
@endif
