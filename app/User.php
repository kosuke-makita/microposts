<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

   
    protected $fillable = [
        'name', 'email', 'password',
    ];

  public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }

    public function follow($userId)
{
   
    $exist = $this->is_following($userId);
    
    $its_me = $this->id == $userId;

    if ($exist || $its_me) {
        
        return false;
    } else {
        
        $this->followings()->attach($userId);
        return true;
    }
}

public function unfollow($userId)
{
    
    $exist = $this->is_following($userId);
   
    $its_me = $this->id == $userId;


    if ($exist && !$its_me) {
  
        $this->followings()->detach($userId);
        return true;
    } else {
       
        return false;
    }
}


public function is_following($userId) {
    return $this->followings()->where('follow_id', $userId)->exists();
}


    protected $hidden = [
        'password', 'remember_token',
    ];

public function feed_microposts()
    {
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
     public function favoritings()
    {
        return $this->belongsToMany(Micropost::class, 'favorite', 'micropost_id', 'user_id')->withTimestamps();
    }
    
    public function favorite($micropostId)
{
    $exist = $this->is_favoriting($micropostId);
    // confirming that it is not you
    $its_me = $this->id == $micropostId;

    if ($exist || $its_me) {
        // do nothing if already following
        return false;
    } else {
        // follow if not following
        $this->favoritings()->attach($micropostId);
        return true;
    }
}

public function unfavorite($micropostId)
{
    // confirming if already following
    $exist = $this->is_favoriting($micropostId);
    // confirming that it is not you
    $its_me = $this->id == $micropostId;


    if ($exist && !$its_me) {
        // stop following if following
        $this->favoritings()->detach($micropostId);
        return true;
    } else {
        // do nothing if not following
        return false;
    }
}


public function is_favoriting($micropostId) {
    return $this->favoritings()->where('micropost_id', $micropostId)->exists();
}
    
    
    
    
}