<?php

namespace App\Http\Controllers;

use App\Helpers\FormatResponse;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        if(!Auth::guard('sanctum')->check()) {
            return response()->json(FormatResponse::error(403, 'login'));
        }

        $user = Auth::guard('sanctum')->user();
        $post = $user->posts()->create($request->all());

        if($request->input('categories') != null){
            $post->categories()->attach($request->input('categories'));
        }

        return $post;
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        if(!Auth::guard('sanctum')->check()) {
            return response()->json(FormatResponse::error(403, 'login'));
        } else if(!Auth::guard('sanctum')->user()->posts->contains($post)){
            return response()->json(FormatResponse::error(403, 'permission'));
        }

        if($request->input('categories') != null){
            foreach ($post->categories as $cat) {
                $post->categories()->detach($cat->id);
            }
            $post->categories()->attach($request->input('categories'));
        }

        $post->update($request->all());

        return $post;
    }

    public function destroy(Post $post)
    {
        if(!Auth::guard('sanctum')->check()) {
            return response()->json(FormatResponse::error(403, 'login'));
        } else if(!Auth::guard('sanctum')->user()->posts->contains($post)){
            return response()->json(FormatResponse::error(403, 'permission'));
        }

        $post->delete();

        return response()->json(FormatResponse::success());
    }
}
