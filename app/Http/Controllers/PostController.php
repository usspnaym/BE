<?php

namespace App\Http\Controllers;

use App\Helpers\FormatResponse;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return Post::with(['images','user'])->get();
    }

    public function store(Request $request)
    {
        if(!Auth::guard('sanctum')->check()) {
            return response()->json(FormatResponse::error(403, 'login'));
        }

        $request->validate([
            'image.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'name' => 'required',
        ]);
        $user = Auth::guard('sanctum')->user();
        $post = $user->posts()->create($request->all());

        if($request->input('categories') != null){
            $post->categories()->attach($request->input('categories'));
        }

        if($request->hasfile('image')){
            foreach($request->file('image') as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->storeAs(
                    'uploads',
                    $user->id . '_' . $name . '_' . Str::random(4)
                );
                $post->images()->create([
                    'name' => $name,
                    'path' => $path
                ]);
            }
        }
        $post->save();

        return $post;
    }

    public function show(Post $post)
    {
        return $post->load(['images','user']);
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
