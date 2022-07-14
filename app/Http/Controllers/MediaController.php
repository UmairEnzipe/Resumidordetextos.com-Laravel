<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $media = Media::all()->reverse();
        return view('admin.media.add')->with([
            'media' => @$media,
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

        $request->validate([
            'feature' => 'required|mimes:png,jpg,jpeg,webp,svg|max:4096',
        ]);
        // ORIGINAL IMAGE
        //Target => Year/Month
        $target = date('Y') . '/' . date('M');
        // Create Directory
        if (!Storage::exists($target)) {
            Storage::makeDirectory($target, 0777, true, true);
        }
        //Get File Extension
        $ext = "." . $request->file('feature')->getClientOriginalExtension();
        //remove spaces and special character form name
        $filename_with_ext = preg_replace('/[^A-Za-z0-9\.]/', "", $request->file('feature')->getClientOriginalName());
        // GET FILENAME WITHOUT EXTENSION
        $parts = explode('.', $filename_with_ext);
        $last = array_pop($parts);
        $parts = array(implode('.', $parts), $last);
        $filename_without_ext = $parts[0];
        // END FILENAME WITHOUT EXTENSION
        $rand = rand(0, 100);
        $filename = $filename_without_ext . "_" . $rand . "_" . $ext;
        $path = $request->file('feature')->storeAs(
            $target, $filename
        );
        $parent = Media::create([
            'path' => 'storage/' . $path,
            'root_directory' => $target,
            'dimension' => 'original',
        ]);
        $parent->parent_id = $parent->id;
        $parent->save();
        if ($request->file('feature')->getClientOriginalExtension() == "svg") {
            return redirect()->back();
        }
        // COMPRESS IMAGE
        $image_width = Image::make($request->file('feature'))->width();
        if (intval($image_width) >= 900) {
            $filename = $filename_without_ext . "_" . $rand . "_900xauto" . $ext;
            $compress_image_path = 'storage/' . $target . '/' . $filename;
            Image::make($request->file('feature'))->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($compress_image_path), 25);
            Media::create([
                'parent_id' => $parent->id,
                'path' => $compress_image_path,
                'root_directory' => $target,
                'dimension' => '900xauto',
            ]);
        }
        if (intval($image_width) >= 300) {
            $filename = $filename_without_ext . "_" . $rand . "_300xauto" . $ext;
            $thumbnail_path = 'storage/' . $target . '/' . $filename;
            Image::make($request->file('feature')->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($thumbnail_path), 10);
            Media::create([
                'parent_id' => $parent->id,
                'path' => $thumbnail_path,
                'root_directory' => $target,
                'dimension' => '300xauto',
            ]);
        }
        $filename = $filename_without_ext . "_" . $rand . "_150x150" . $ext;
        $small_image_path = 'storage/' . $target . '/' . $filename;
        $img = Image::make($request->file('feature')->getRealPath())->resize(150, 150)->save(public_path($small_image_path), 100);
        Media::create([
            'parent_id' => $parent->id,
            'path' => $small_image_path,
            'root_directory' => $target,
            'dimension' => '150x150',
        ]);
        return redirect()->back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $this->authorize('super_admin');
        if (Media::find($id)) {
            Media::destroy($id);
        }
        return redirect()->back();
    }
    public function trash_list()
    {
        $this->authorize('super_admin');
        $media = Media::onlyTrashed()->get();
        return view('admin.media.trash')->with(['media' => $media]);
    }
    public function media_permanent_destroy($id)
    {
        $this->authorize('super_admin');
        $media = Media::onlyTrashed()->find($id);
        $path = $media->path;
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
            $media->forceDelete();
        } else {
            $media->forceDelete();
        }
        return redirect()->back();
    }

    public function media_restore($id)
    {
        $this->authorize('super_admin');
        Media::withTrashed()->find($id)->restore();
        return redirect()->back();
    }

}
