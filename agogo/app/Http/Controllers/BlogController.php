<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // All published posts
    public function index()
    {
        $posts = Post::published()
            ->with('author')
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    // Single post
    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with('author')
            ->firstOrFail();

        // Previous / Next posts (optional but nice)
        $previous = Post::published()
            ->where('published_at', '<', $post->published_at)
            ->latest('published_at')
            ->first();

        $next = Post::published()
            ->where('published_at', '>', $post->published_at)
            ->oldest('published_at')
            ->first();

        return view('blog.show', compact('post', 'previous', 'next'));
    }
}