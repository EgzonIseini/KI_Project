<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $with = ['image'];
    protected $fillable = ['name','description','user_id','image_id','visibility'];

    public function image(){
        return $this->belongsTo(Image::class);
    }
}
