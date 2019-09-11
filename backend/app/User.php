<?php

namespace App;

use App\Models\Album;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use  Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
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

    protected $with = ['image'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function publicAlbums()
    {
        return $this->hasMany(Album::class)->where('visibility',Post::$PUBLIC);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
