<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ToolsController extends Controller
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
        $tools = Tool::select('id', 'tool_name', 'tool_parent', 'tool_lang')->orderBy('created_at', 'ASC')->get();
        return view('admin.tools.index')->with('tools', $tools);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_files = array_reverse(Storage::files('media'));
        $parent = Tool::select('id', 'tool_name')->whereColumn('id', 'tool_parent')->get();
        if ($parent) {
            return view('admin.tools.add')->with('parent', $parent);
        }
        $html = '';
        if (count($all_files) > 0) {
            foreach ($all_files as $image) {
                $html .= view('admin.partials.gallary_image')->with('image', $image)->render();
            }
            return view('admin.tools.add')->with('images', $html);
        }

        return view('admin.tools.add');
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
            'is_home' => 'unique:tools,is_home',
            'tool_slug' => 'unique:tools,tool_slug',
        ]);
        $contentKey = !empty($request->contentKey) ? $request->contentKey : '';
        $contentValue = !empty($request->contentKey) ? $request->contentValue : '';
        $inputType = !empty($request->contentKey) ? $request->inputType : '';
        $contentArr = [];
        if (!empty($contentKey) && !empty($contentValue)) {
            for ($i = 0; $i < count($contentKey); $i++) {
                $contentArr[$contentKey[$i]]['type'] = $inputType[$i];
                $contentArr[$contentKey[$i]]['value'] = $contentValue[$i];
            }
        }
        if ($request->tool_parent == 0) {
            $content_json = json_encode($contentArr);
        } else {
            $content_json = Tool::select('tool_content')->where('id', $request->tool_parent)->get();
            $content_json = $content_json[0]->tool_content;
        }
        $is_home = 0;
        if ($request->has('is_home')) {
            $is_home = $request->is_home;
        }
        $create_record = Tool::create([
            'tool_name' => $request->tool_name,
            'tool_slug' => $request->tool_slug,
            'tool_meta_title' => $request->tool_meta_title,
            'tool_meta_description' => $request->tool_meta_description,
            'tool_lang' => $request->tool_lang,
            'tool_parent' => $request->tool_parent,
            'tool_content' => $content_json,
            'is_home' => $is_home,
        ])->id;
        if ($request->tool_parent == 0) {
            Tool::where('id', $create_record)->update(['tool_parent' => $create_record]);
        }
        if ($create_record) {
            return redirect()->back();
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
        $tools = Tool::find($id);
        $parent = Tool::select('id', 'tool_name')->whereColumn('id', 'tool_parent')->get();
        if ($tools) {
            return view('admin.tools.edit')->with('tool', $tools)->with([
                'parent' => $parent, 'images' => $images,
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
    public function update(Request $request, $id)
    {
        $tool = Tool::find($id);
        $tool->tool_name = $request->tool_name;
        $tool->tool_meta_title = $request->tool_meta_title;
        $tool->tool_meta_description = $request->tool_meta_description;
        $contentKey = !empty($request->contentKey) ? $request->contentKey : '';
        $contentValue = !empty($request->contentKey) ? $request->contentValue : '';
        $inputType = !empty($request->contentKey) ? $request->inputType : '';
        $contentArr = [];
        if (!empty($contentKey) && !empty($contentValue)) {
            for ($i = 0; $i < count($contentKey); $i++) {
                $regex = '/[^A-Za-z1-9\_]/gi';
                $contentKey[$i] = Str::replace($regex, "_", $contentKey[$i]);
                $contentArr[$contentKey[$i]]['type'] = $inputType[$i];
                $contentArr[$contentKey[$i]]['value'] = $contentValue[$i];
            }
        }
        $content_json = json_encode($contentArr);
        $tool->tool_content = $content_json;
        $tool->save();
        return redirect()->back();

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
        $tools = Tool::find($id);
        $tools->delete();
        return redirect()->back();
    }

    public function trash_list()
    {
        $this->authorize('super_admin');
        $tools = Tool::onlyTrashed()->get();
        return view('admin.tools.trash')->with(['tools' => $tools]);
    }
    public function tool_permanent_destroy($id)
    {
        $this->authorize('super_admin');
        Tool::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }

    public function tool_restore($id)
    {
        $this->authorize('super_admin');
        Tool::withTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function download($id)
    {
        $tool = Tool::select('tool_content')->where('id', $id)->first();
        if ($tool) {
            header('Content-Type: application/json');
            $content = $tool['tool_content'];
            $content_to_store = json_encode(json_decode($content), JSON_PRETTY_PRINT);
            $target = "tool_content";
            if (!Storage::exists($target)) {
                Storage::makeDirectory($target, 0777, true, true);
            }
            $fileName = "content_" . time() . ".json";
            $path = $target . '/' . $fileName;
            Storage::path($path);
            if (Storage::put($target . '/' . $fileName, $content_to_store)) {
                return Storage::download($path);
            }
        }
    }
    public function upload_tool_content(Request $request, $id)
    {
        $this->authorize('super_admin');
        $tool = Tool::find($id);
        $tool->tool_content = $request->upload_json;
        $tool->save();
        return redirect()->back();
    }
}
