<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public static $PUBLIC = 'PUBLIC';
    public static $PRIVATE = 'PRIVATE';

    protected $with = ['image'];

    protected $fillable = ['image_id', 'user_id', 'name', 'description', 'visibility', 'album_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
