<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $categories = DB::table('categories')->get();
        $categories = Category::with('posts')->get();
        return view('posts', [
            'categories' => $categories,
            'title' => 'Blog',
            'posts' => Post::filter(request(['search', 'category', 'author']))
                      ->latest()
                      ->paginate(6)
                      ->withQueryString()
        ]);

    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts-add', compact('categories'));
    }
    public function tambah()
    {
        return view('category-add');
    }

    public function bikin(Request $request)
    {
        // $slug = Str::slug($request->name);

        // DB::table('categories')->insert([
        //     'name' => $request->name,
        //     'slug' => $slug,
        //     'color'=> $request->color,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        // dd($request->all());

        $request->validate([
            'name' => 'required|unique:categories|max:225',
            'color' => 'required',
        ]);

        DB::table('categories')->insert([
        'name' => $request->input('name'),
        'slug' => Str::slug($request->input('name')),
        'color' => $request->input('color'),
        'created_at' => now(),
        'updated_at' => now()
        ]);
        
        Session::flash('message', 'New category Succesfully Added!');

        return redirect()->route('posts');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        if(!$category){
            abort(404);
        }
        return view('category-edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$id.'|max:225',
            'color' => 'required',
        ]);

        DB::table('categories')->where('id', $id)->update([
        'name' => $request->input('name'),
        'color' => $request->input('color'),
        'updated_at' => now()
        ]);

        Session::flash('message', 'Category Succesfully Edited!');

        return redirect()->route('posts');

    }

    public function delete($id)
    {
        // $category = DB::table('categories')->where('id', $id)->delete(); 

        // Session::flash('message', 'Category Succesfully Deleted!');
        // return redirect()->route('posts');

        
        // $defaultCategoryId = 1;
        
        // DB::table('posts')->where('category_id', $id)->update([
        //     'category_id' => $defaultCategoryId
        // ]);

        // DB::table('categories')->where('id', $id)->delete();
        // Session::flash('message', 'Category Succesfully Deleted!');
        // return redirect()->route('posts');


        // Cegah hapus kategori default kalau kamu punya semacam default tetap
        $defaultCategoryId = 1;
        if ($id == $defaultCategoryId) {
            return redirect()->back()->with('error', 'Default Category cannot be deleted.');
        }

        // Cek apakah ada post yang memakai kategori ini
        $usingCount = Post::where('category_id', $id)->count();

        if ($usingCount > 0) {
            return redirect()->back()->with('error', "Category cannot be deleted because {$usingCount} post is using it.");
        }

        // Kalau tidak dipakai, hapus kategori
        Category::where('id', $id)->delete();

        return redirect()->route('posts')->with('message', 'Category successfully deleted!');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
