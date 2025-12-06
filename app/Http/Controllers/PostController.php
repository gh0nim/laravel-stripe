<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        return view('posts.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $posts = Post::all();
        Post::create([
            'user_id' => auth('web')->user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

         return to_route('posts');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, int $id)
    {
        Gate::authorize('update', $post);
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Post $post, int $id)
    {
        Gate::authorize('update', $post);
        Post::where('user_id', $request->id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

        return to_route('posts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post,string $id)
    {
             Gate::authorize('delete', $post);

    }
}
