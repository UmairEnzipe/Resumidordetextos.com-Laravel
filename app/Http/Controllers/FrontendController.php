<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Media;
use App\Models\Tool;
use Illuminate\Support\Facades\Route;

class FrontendController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        $tool = Tool::where('is_home', 1)->first();
        if ($tool) {
            return $this->get_tool($tool);
        } else {
            return view('main')->with('show_main', true);
        }
    }

    public function get_tool($tool)
    {
        //
        $custom = $this->CUSTOM_FUNCTION();
        //
        $is_home = 0;
        if (!$tool->is_home) {
            if ($tool->id == $tool->tool_parent) {
                $slug = $tool->tool_slug;
                $slug_n_home['is_home'] = 0;
            } else {
                $slug_n_home = Tool::select('tool_slug', 'is_home')->where('id', $tool->tool_parent)->first();
                $slug = $slug_n_home['tool_slug'];
            }
            if ($slug_n_home['is_home'] != 1) {
                $view = 'layout.frontend.pages.' . $slug;
            } else {
                $view = 'layout.frontend.pages.home';
                $is_home = 1;
            }
            $links = Tool::select('tool_slug', 'tool_lang')->where('tool_parent', $tool->tool_parent)->get();
        } else {
            $links = Tool::select('tool_slug', 'tool_lang')->where('tool_parent', $tool->tool_parent)->get();
            $view = 'layout.frontend.pages.home';
            $slug = $tool->tool_slug;
            $is_home = 1;
        }
        $meta_title = $tool->tool_meta_title;
        $meta_description = $tool->tool_meta_description;
        $content = json_decode($tool->tool_content);
        return view($view)->with([
            'tool' => $tool,
            'content' => $content,
            'links' => @$links,
            'parent_slug' => $slug,
            'is_home' => $is_home,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'show_canonicals' => true,
            'custom' => $custom,
        ]);
    }
    public function native_language_tool($slug = null)
    {
        $tool = Tool::where('tool_slug', $slug)->first();
        if ($tool) {
            if ($tool->is_home) {
                return redirect()->route('home');
            }
            if ($tool->id != $tool->tool_parent) {
                abort(404);
                exit;
            }
            return $this->get_tool($tool);
        } else {
            abort(404);
        }
    }
    public function other_language_tool($lang = null, $slug = null)
    {
        $native_language = config('constants.native_languge');
        $tool = Tool::where([['tool_lang', $lang], ['tool_slug', $slug]])->first();
        if ($tool) {
            if ($native_language == $lang) {
                return redirect()->route('native_language_tool', ['slug' => $slug]);
            } else {
                return $this->get_tool($tool);
            }
        } else {
            abort(404);
        }
    }

    public function blog()
    {
        //
        $custom = $this->CUSTOM_BLOG_FUNCTION();
        //
        $blogs = get_blogs_by_limit(10);
        if (is_null($blogs)) {
            return view('layout.frontend.pages.blog')->with([
                'blogs' => null,
                'meta_title' => "title goes here",
                'meta_description' => "description goes here",
                'custom' => null,
            ]);
        }
        return view('layout.frontend.pages.blog')->with([
            'blogs' => $blogs,
            'meta_title' => "title goes here",
            'meta_description' => "description goes here",
            'custom' => $custom,
        ]);

    }
    public function single_blog($slug)
    {
        //
        $custom = $this->CUSTOM_BLOG_FUNCTION();
        //
        $media = new Media();
        $blog_model = new Blog();
        $blog = $blog_model->get_blog($slug);
        if (is_null($blog)) {
            abort(404);
        } else {
            $blog = $blog->toArray();
        }
        $img_id = $blog['img_id'];
        $images = $media->get_images_by_id($img_id);
        foreach ($images as $value) {
            $arr[$value['dimension']] = $value['path'];
        }
        $blog['images'] = $arr;

        return view('layout.frontend.pages.single-blog')->with([
            'blog' => $blog,
            'meta_title' => $blog['meta_title'],
            'meta_description' => $blog['meta_description'],
            'custom' => $custom,
        ]);
    }
    public function privacy_policy()
    {
        return view('layout.frontend.pages.privacy-policy');
    }
    public function terms_and_conditions()
    {
        return view('layout.frontend.pages.terms-and-conditions');
    }
    // Custom Function for your general purpose
    public function CUSTOM_FUNCTION()
    {
    }
    // Custom Function for your Blog related
    public function CUSTOM_BLOG_FUNCTION()
    {
    }
    //about-us
    public function about_us()
    {
        return view('layout.frontend.pages.about-us');
    }
    //contact-us
    public function contact_us()
    {
        return view('layout.frontend.pages.contact-us');
    }

    // sitemap
    public function sitemap()
    {
        $tools = Tool::whereColumn('id', 'tool_parent')->with('children')->get();
        $links = [];
        if ($tools->count() > 0) {
            foreach ($tools as $key => $item) {
                foreach ($item->children as $c_key => $c_item) {
                    if ($c_item->is_home) {
                        $links[] = route('home');
                    } else {
                        if ($c_item->id == $c_item->tool_parent) {
                            $links[] = route('native_language_tool', ['slug' => $c_item->tool_slug]);
                        } else {
                            $links[] = route('other_language_tool', ['lang' => $c_item->tool_lang, 'slug' => $c_item->tool_slug]);
                        }
                    }
                }
            }
        }
        if (Route::has('page.blog')) {
            $links[] = route('page.blog');
        }
        $blogs = Blog::all();
        if ($blogs->count() > 0) {
            foreach ($blogs as $key => $item) {
                $links[] = route('page.single_blog', ['slug' => $item->slug]);
            }
        }
        if (Route::has('privacy_policy')) {
            $links[] = route('privacy_policy');
        }
        if (Route::has('terms_and_conditions')) {
            $links[] = route('terms_and_conditions');
        }
        if (Route::has('page.about_us')) {
            $links[] = route('page.about_us');
        }
        $links = array_merge($links, $this->CUSTOM_SITEMAP_LINKS());
        return response(view('sitemap', ['links' => $links]))
            ->withHeaders([
                'Content-Type' => 'text/xml',
            ]);
    }
    public function CUSTOM_SITEMAP_LINKS()
    {
        $links = [];
        return $links;
    }
}
