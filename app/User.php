<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    // このユーザがフォロー中のユーザ
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    // このユーザをフォロー中のユーザ
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    // Userが持つモデルの数をカウントする
    public function loadRelationshipCounts()
    {
        $this->loadCount(['microposts', 'followings', 'followers', 'favorites']);
    }
    
    public function follow($userId){
        // すでにフォローしているか
        $exist = $this->is_following($userId);
        // 対象が自分自身か
        $its_me = $this->user_id == $userId;
        
        if($exist || $its_me){
            return false;
        }else{
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId){
        $exist = $this->is_following($userId);
        $its_me = $this->user_id == $userId;
        
        if($exist && !$its_me){
            $this->followings()->detach($userId);
            return true;
        }else{
            return false;
        }
    }
    
    public function is_following($userId){
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    // このユーザとフォロー中ユーザの投稿に絞り込む
    public function feed_microposts()
    {
        // このユーザがフォロー中のユーザのidを取得し配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // 自分のidも作成した配列に追加
        $userIds[] = $this->id;
        // 投稿を絞り込む
        return Micropost::whereIn('user_id', $userIds);
    }
    
    // このユーザがお気に入りに登録したmicroposts
    public function favorites()
    {
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')->withTimestamps();
    }
    
     public function is_favorite($id){
        return $this->favorites()->where('micropost_id', $id)->exists();
    }
    
    public function favorite($id){
        // すでにお気に入りにしているか
        $exist = $this->is_favorite($id);

        if($exist){
            return false;
        }else{
            $this->favorites()->attach($id);
            return true;
        }
    }
    
    public function unfavorite($id){
        // すでにお気に入りにしているか
        $exist = $this->is_favorite($id);
        
        if($exist){
            $this->favorites()->detach($id);
            return true;
        }else{
            return false;
        }
    }
}
