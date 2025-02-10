<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use AElnemr\RestFullResponse\CoreJsonResponse;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use CoreJsonResponse;

    public function index()
    {
        $blogs = Blog::all();
        return $this->ok(BlogResource::collection($blogs)->resolve());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:blogs,title'],
            'content' => ['required', 'string'],
            'created_by' => ['required', 'string'],
            'updated_by' => ['required', 'string'],
        ]);

        // $user = Auth::user();
        // \Log::info('Authenticated user:', ['id' => Auth::user()->id]);

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'created_by' => $validated['created_by'],
            'updated_by' => $validated['updated_by'],

        ]);

        // if ($request->hasFile('image')) {
        //     $blog->addMedia($request->file("image"))
        //         ->toMediaCollection("blogs");
        // }

        return $this->created((new BlogResource($blog))->resolve());
    }

    public function show($id)
    {
        $blog = Blog::all()->findOrFail($id);
        return response()->json($blog);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:publish,draft',
            'image' => 'nullable|file',
        ]);

        $blog->update($validated);

        if ($request->has('title')) {
            $blog->slug = Str::slug($validated['title']);
        }

        // if ($request->hasFile('image')) {
        //     $blog->addMedia($request->file("image"))
        //         ->toMediaCollection("blogs");
        // }

        return response()->json($blog);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return response()->json(null, 204);
    }
}
