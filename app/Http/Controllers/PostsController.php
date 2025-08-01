<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostsController extends Controller
{
    function add() {
        return view('posts-add');
    }
    
    function create(Request $request){

        $request->validate([
            'title' => 'required|unique:posts|max:225',
            'body' => 'required',
        ]);

        $title = $request->title;
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
            // Cek slug unik
        while (DB::table('posts')->where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++; }
        
        DB::table('posts')->insert([
            'title' => $title,
            'body' => $request->body,
            'slug' => $slug,
            'author_id' => Auth::id(),
            'category_id' => $request->category_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Session::flash('message', 'New Blog Succesfully Added!');

        return redirect()->route('posts');
    }

    function edit($id)
    {
        $posts = DB::table('posts')->where('id', $id)->first();
        $categories = Category::all();
        if(!$posts){
            abort(404);
        }
        return view('posts-edit', compact('posts', 'categories'));
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:posts,title,'.$id.'|max:225',
            'body' => 'required',
        ]);

        DB::table('posts')->where('id', $id)->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'updated_at' => now()
        ]);

        Session::flash('message', 'Blog Succesfully Updated!');
        return redirect()->route('posts');
    }

    function delete($id)
    {
        $posts = DB::table('posts')->where('id', $id)->delete(); 

        Session::flash('message', 'Blog Succesfully Deleted!');
        return redirect()->route('posts');
    }


    
}
