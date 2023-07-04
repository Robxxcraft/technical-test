<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::when($request->has('search'), function($q)use($request){
            $q->where('title', 'like', '%'.$request->search.'%')->orWhere('category', 'like', '%'.$request->search.'%')->orWhere('content', 'like', '%'.$request->search.'%')->orWhere('author', 'like', '%'.$request->search.'%');
        })->latest()->paginate(10);
        return PostResource::collection($posts);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|unique:posts,title',
            'category' => 'required',
            'content' => 'required',
            'author' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'content' => $request->content,
            'author' => $request->author,
        ]);
            
        return response()->json(['success' => 'Post added successfully'], 201);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return new PostResource($post);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3|unique:posts,title,'.$id,
            'category' => 'required',
            'content' => 'required',
            'author' => 'required',
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'content' => $request->content,
            'author' => $request->author,
        ]);
            
        return response()->json(['success' => 'Post updated successfully'], 201);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['success' => 'Post deleted sucessfullfy'], 200);
    }
}
