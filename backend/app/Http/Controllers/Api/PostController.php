<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PostRequests\CreatePostRequest;
use App\Models\Album;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    public function getPostsOfAUser()
    {
        $id = Input::get('id');
        $size = 15;
        if (!isset($id)) {
            return response('Insufficient parameters', 412);
        }

        if (Input::exists('size')) {
            $size = Input::get('size');
        }


        if ($id == Auth::user()->id) {
            return Auth::user()->posts()->paginate($size);
        } else {
            return Post::where('visibility', 'public')->where('user_id', $id)->paginate($size);
        }
    }

    public function create(\App\Http\Requests\PostRequests\CreatePostRequest $request)
    {
        $data['visibility'] = $request->get('visibility');
        $data['description'] = $request->get('description');
        $data['name'] = $request->get('name');
        $data['album_id'] = $request->get('album_id');
        $data['user_id'] = Auth::user()->id;

        $file = $request->file('image');

        $fileMoved = $this->uploadFile($file);

        $mimeType = $fileMoved->getMimeType();
        $dir = sprintf('uploads/%s/%s', date("Y"), date("m"));

        $dataIMG = [
            "name" => $fileMoved->getFilename(),
            "mimetype" => $mimeType,
            "size" => filesize($fileMoved->getPathname()),
            "path" => $dir,
        ];

        Image::unguard();
        $image = Image::create($dataIMG);
        Image::reguard();
        $data['image_id'] = $image->id;

        Post::unguard();
        $post = Post::create($data);
        Post::reguard();

        $album = Album::find($request->get('album_id'));
        $album->image_id = $image->id;
        $album->save();

        return Post::find($post->id);

    }

    public function uploadFile(UploadedFile $upload)
    {
        $dir = sprintf('uploads/%s/%s', date("Y"), date("m"));
        $filename = md5($upload->getClientOriginalName() . microtime() . rand(0, 10000)) . "." . $upload->getClientOriginalExtension();

        $moved = $upload->move($dir, $filename);

        return $moved;
    }

}
