<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    public function show($id){
        $user = User::findOrFail($id);
        
        // 関連するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        // ユーザの投稿一覧を作成日時の降順で取得
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        // ユーザ詳細ビューでそれらを表示
        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
    }
    
    // フォロー一覧ページを表示する
    public function followings($id)
    {
        $user = User::findOrFail($id);
        
        $user->loadRelationshipCounts();
        $followings = $user->followings()->paginate(10);
    
        return view('users.followings', [
            'user' => $user,
            'users' => $followings,
        ]);
    }
    
    // フォロワー一覧ページを表示する
    public function followers($id)
    {
        $user = User::findOrFail($id);
        
        $user->loadRelationshipCounts();
        $followers = $user->followers()->paginate(10);
        
        return view('users.followers', [
            'user' => $user,
            'users' => $followers
        ]);
    }
    
    // お気に入り一覧ページを表示する
    public function favorites($id)
    {
        $user = User::findOrFail($id);
        
        $user->loadRelationshipCounts();
        $favorites = $user->favorites()->paginate(10);
        
        return view('users.favorites', [
            'user' => $user,
            'favorites' => $favorites,
        ]);
    }
    
}
