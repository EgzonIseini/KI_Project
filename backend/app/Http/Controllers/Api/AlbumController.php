<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AlbumRequests\CreateAlbumRequest;
use App\Models\Album;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class AlbumController extends Controller
{
    public function getPhotosOfAnAlbum()
    {
        $id = Input::get('id');

        if (!isset($id)) {
            return response('Insufficient parameters', 412);
        }

        return Post::where('album_id', $id)->where(function (Builder $query) {
            $query->where('user_id', Auth::user()->id)
            ->orWhere('visibility',Post::$PUBLIC);
        })->get();
    }

    public function create(CreateAlbumRequest $request)
    {
        $data['visibility'] = $request->get('visibility');
        $data['description'] = $request->get('description');
        $data['name'] = $request->get('name');
        $data['user_id'] = Auth::user()->id;

        $album = Album::create($data);

        return $album;
    }

}
