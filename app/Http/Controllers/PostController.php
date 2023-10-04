<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagination = $request->query('pagination', 5);
        $search = $request->query('search', '');

        $postsQuery = Post::query();

        // Apply search filter
        if ($search) {
            $postsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('identity_number', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results and append query parameters
        $posts = $postsQuery->paginate($pagination)->appends([
            'pagination' => $pagination,
            'search' => $search,
        ]);

        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gambar' => 'image|file|max:2400',
            'title' => 'required|max:255',
            'category' => 'required',
            'content' => 'required',
        ]);

        // Menambahkan data yang tidak validasi ke dalam array
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = SlugService::createSlug(Post::class, 'slug', $request->title);
        $validatedData['excerpt'] = Str::limit($request->content, 120, '...');

        if ($request->file('gambar')) {
            $validations['gambar'] = $request->file('gambar')->store('img-sourece');
        }

        // Menyimpan data ke dalam tabel posts
        $post = Post::create($validatedData);

        // Redirect atau lakukan operasi lainnya setelah penyimpanan berhasil
        return redirect()->route('post.index', $post->slug)->with('success', 'Post berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'gambar' => 'image|file|max:2400',
            'title' => 'required|max:255',
            'category' => 'required',
            'content' => 'required',
        ]);

        // Menambahkan data yang tidak validasi ke dalam array
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = SlugService::createSlug(Post::class, 'slug', $request->title);
        $validatedData['excerpt'] = Str::limit(strip_tags($request->content, 120, '...'));

        // Check if a new image is uploaded
        if ($request->hasFile('gambar')) {
            // Delete old image if it exists
            if ($post->gambar && Storage::exists($post->gambar)) {
                Storage::delete($post->gambar);
            }

            // Store new image
            $validatedData['gambar'] = $request->file('gambar')->store('img-source');
        }

        $post->update($validatedData);

        return redirect()->route('post.index', $post->slug)->with('success', 'Post berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->gambar) {
            Storage::delete($post->gambar);
        }

        post::destroy($post->id);
        return  redirect()->route('posts.index')->with('success', 'post deleted successfully');
    }
}
