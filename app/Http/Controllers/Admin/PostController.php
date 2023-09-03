<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('admin.posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $img_path = Storage::put('uploads', $request['image']);

        $data = $request->validate([
            'title' => ['required', 'unique:posts', 'min:3', 'max:255'],
            'image' => ['required','image'],
            'content' => ['required', 'min:10'],
            'tags' => ['exists:tags,id'],
        ]);

        
        $data['image'] = $img_path;
        $data['slug'] = Str::of($data['title'])->slug('-');
        $newPost = Post::create($data);

        
        $newPost->slug = Str::of("$newPost->id " . $data['title'])->slug('-');
        $newPost->save();
        if ($request->has('tags')){
            $newPost->tags()->sync($request->tags);
        }

        return redirect()->route('admin.posts.show', $newPost);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => ['required', 'unique:posts', 'min:10', 'max:255'],
            'image' => ['url:https'],
            'content' => ['required', 'min:10'],
            'tags' => ['exists:tags,id'],
        ]);
        $data['slug'] = Str::of($data['title'])->slug('-');

        $post->update($data);

        if ($request->has('tags')){
            $post->tags()->sync( $request->tags);
        }

        return redirect()->route('admin.posts.show', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }

    public function deletedIndex(){
        $posts = Post::onlyTrashed()->paginate(10);

        return view('admin.posts.deleteIndex', compact('posts'));
    }

    public function restore ($id){
        $post = Post::onlyTrashed()->findOrFail($id);
        //dd($post);
        $post->restore();

        return redirect()->route('admin.posts.show', $post);
    }

    
    public function irretrievablyDelete (string $slug){
        $post = Post::onlyTrashed()->findOrFail($slug);
        Storage::delete($post->image);

        $post->tags()->sync([]);

        $post->forceDelete();

        return redirect()->route('admin.posts.index');
    }
}
