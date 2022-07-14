<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }
    public function dashboard()
    {
        // $audits = Tool::with('audits')->get();
        // $audits = Tool::find(1)->audits;
        // dd($audits);
        return view('admin.dashboard');
    }
    public function user_list()
    {
        $this->authorize('super_admin');
        $users = User::whereNotIn('admin_level', [0, 1])->get();
        return view('admin.users.index', compact('users'));
    }
    public function trash_list()
    {
        $this->authorize('super_admin');
        $users = User::onlyTrashed()->whereNotIn('admin_level', [0, 1])->get();
        return view('admin.users.trash', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('super_admin');
        return view('admin.users.add');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('super_admin');
        $cookie = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 16);
        $validator = $request->validate([
            'email' => 'unique:admins',
        ]);
        $user = User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hash' => $cookie,
            'admin_level' => $request->admin_level,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if ($user) {
            return redirect()->route('admin.users_list');
        }
    }
    public function user_destroy($id)
    {
        $this->authorize('super_admin');
        if ($user = User::find($id)) {
            $user->delete();
        }
        return redirect()->back()->with('warning', 'User Trashed!');
    }
    public function user_permanent_destroy($id)
    {
        $this->authorize('super_admin');
        User::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('error', 'User Delete Permanently!');
    }
    public function user_restore($id)
    {
        $this->authorize('super_admin');
        User::withTrashed()->find($id)->restore();
        return redirect()->back()->with('message', 'User Restored!');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('super_admin');
        $admin = User::find($id);
        if ($admin) {
            return view('admin.users.edit')->with('admin', $admin);
        }
        return redirect()->back();
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
        $this->authorize('super_admin');
        $admin = User::find($id);
        $cookie = str_shuffle(substr(Hash::make(Str::random(16)), 0, 16));
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->hash = $cookie;
        $admin->save();
        return redirect()->back()->with('message', 'User Updated Successfully');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $cookie = $request->cookie('admin_hash');
        $user = User::where('email', $request->email)->where('hash', $cookie)->first();
        if ($user) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->route('admin.dashboard');
            }
            return redirect("admin/login")->with('info', 'Login details are not valid');
        }
        return redirect("admin/login")->with('info', 'Login details are not valid');
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('home');
    }

    //
    public function settings()
    {
        $media = Setting::where('section', 'media')->get();
        $content = Setting::where('section', 'content')->get();
        return view('admin.settings', compact('media', 'content'));
    }
    public function update_settings(Request $request)
    {
        Setting::updateOrInsert(
            ['key' => 'large_image_width'],
            ['value' => $request->large_image_width, 'section' => 'media', 'type' => 'text']
        );
        Setting::updateOrInsert(
            ['key' => 'thumbnail_width'],
            ['value' => $request->thumbnail_width, 'section' => 'media', 'type' => 'text']
        );
        Setting::updateOrInsert(
            ['key' => 'small_image_width'],
            ['value' => $request->small_image_width, 'section' => 'media', 'type' => 'text']
        );
        Setting::updateOrInsert(
            ['key' => 'small_image_height'],
            ['value' => $request->small_image_height, 'section' => 'media', 'type' => 'text']
        );

        $contentKey = !empty($request->contentKey) ? $request->contentKey : '';
        $sectionType = !empty($request->sectionType) ? $request->sectionType : '';
        $contentValue = !empty($request->contentKey) ? $request->contentValue : '';
        $inputType = !empty($request->contentKey) ? $request->inputType : '';
        $autoload = !empty($request->autoload) ? $request->autoload : '';
        for ($i = 0; $i < count($contentKey); ++$i) {
            Setting::updateOrInsert(
                ['key' => $contentKey[$i]],
                ['value' => $contentValue[$i], 'type' => $inputType[$i], 'section' => $sectionType[$i], 'autoload' => $autoload[$i]]
            );
        }
        return redirect()->back();

    }
    public function modals()
    {
        $images = Media::get_media();
        return view('admin.components')->with([
            'images' => $images,
        ]);
    }
    public function settings_delete(Request $request)
    {
        $this->authorize('super_admin');
        if (Setting::destroy($request->id)) {
            return 1;
        }
    }
    public function setCookie(Request $request, $hash)
    {
        $admin = User::where('hash', $hash)->first();
        if ($admin != null) {
            return response(view('admin.login'))->withCookie(cookie()->forever('admin_hash', $hash));
        } else {
            Cookie::queue(Cookie::forget('admin_hash'));
            return redirect('/');
        }
    }

}
