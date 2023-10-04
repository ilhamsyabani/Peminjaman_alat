<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;

class BlogController extends Controller
{
    public function show(Post $post)
    {
        return view('post', [
            'post' => $post
        ]);
    }
}
