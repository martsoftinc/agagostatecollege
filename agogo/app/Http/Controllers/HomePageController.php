<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index(){
    $latestPosts = \App\Models\Post::published()
    ->latest('published_at')
    ->take(3)
    ->get();

return view('welcome', compact('latestPosts'));
    }
}
