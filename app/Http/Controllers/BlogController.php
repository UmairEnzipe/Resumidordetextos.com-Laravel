<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::select('id', 'title', 'img_id')->orderBy('created_at', 'desc')->get();
        return view('admin.blog.index')->with('blogs', $blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $images = Media::get_media();
        return view('admin.blog.add')->with([
            'images' => @$images,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ok = Blog::create([
            'title' => $request->title,
            'status' => $request->pinch,
            'detail' => $request->blog_detail,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'img_id' => $request->featured_img,
        ]);
        if ($ok) {
            return 1;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $images = Media::get_media();
        $blog = Blog::find($id);
        if ($blog) {
            return view('admin.blog.edit')->with([
                'blog' => $blog,
                'images' => $images,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        $blog = Blog::find(intval($request->id));
        $blog->title = $request->title;
        $blog->status = $request->pinch;
        $blog->detail = $request->blog_detail;
        $blog->slug = $request->slug;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->img_id = $request->featured_img;
        $blog->save();
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('super_admin');
        $blog = Blog::find($id);
        $blog->delete();
        return redirect()->back();
    }

    public function trash_list()
    {
        $this->authorize('super_admin');
        $blogs = Blog::onlyTrashed()->get();
        return view('admin.blog.trash')->with(['blogs' => $blogs]);
    }
    public function blog_permanent_destroy($id)
    {
        $this->authorize('super_admin');
        Blog::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }

    public function blog_restore($id)
    {
        $this->authorize('super_admin');
        Blog::withTrashed()->find($id)->restore();
        return redirect()->back();
    }
}
