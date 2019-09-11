<?php

namespace App\Http\Controllers\Api;

use App\Models\Album;
use App\Models\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

    public function getUserDetails()
    {
        $id = Input::get('user_id');

        if (!isset($id)) {
            $id = Auth::user()->id;
        }
        if($id == Auth::user()->id){
            return Auth::user()->with('albums')->first();
        }
        return User::find($id)->with('publicAlbums')->first();
    }

    public function getTimeline()
    {
        $size = 15;
        if (Input::exists('size')) {
            $size = Input::get('size');
        }
        return Post::with(['user'])->where('visibility', Post::$PUBLIC)->orderBy('created_at', 'DESC')->paginate($size);
    }

    public function getAlbumsOfAUser()
    {
        $size = 15;
        if (!Input::exists('user_id')) {
            return response('Insufficient Parameters', 412);
        }

        $id = Input::get('user_id');

        if (Input::exists('size')) {
            $size = Input::get('size');
        }


        if ($id == Auth::user()->id) {
            return Auth::user()->albums()->paginate($size);
        } else {
            return Album::where('visibility', 'public')->where('user_id', $id)->paginate($size);
        }
    }

    public function updateUserDetails(Request $request)
    {
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $imageID  = $request->get('image_id');

        if(isset($firstName))
            Auth::user()->first_name = $firstName;
        if(isset($lastName))
            Auth::user()->last_name = $lastName;
        if(isset($imageID))
            Auth::user()->image_id = $imageID;

        Auth::user()->save();

        return Auth::user();
    }

}
