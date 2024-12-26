<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Http\Traits\QueryRelationships;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use QueryRelationships;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Blog::class);

        $blogsList = Blog::with('user');

        $blogsList->when(request('search'), fn($q) => $q->where('status', 'like', '%' . request('search') . '%'))
            ->orWhere('created_at', 'like', '%' . request('search') . '%');

        return BlogResource::collection(
            $blogsList->latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Blog::class);

        $event = Blog::create([
            ...$request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|nullable|string',
            ]),
            'user_id' => $request->user()->id,
        ]);

        return new BlogResource($this->loadRelationships($event));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        Gate::authorize('view', $blog);
        return new BlogResource($this->loadRelationships($blog));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        Gate::authorize('update', $blog);

        $blog->update(
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|nullable|string',
            ]),
        );

        return new BlogResource($this->loadRelationships($blog));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        Gate::authorize('delete', $blog);
        $blog->delete();
        return response()->json(status: 204);
    }
}
