<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'detail', 'slug', 'meta_title', 'meta_description', 'img_id', 'status'];

    public function media()
    {
        return $this->belongsTo(Media::class, 'img_id');
    }
    public function get_blog($slug = null)
    {
        if (is_null($slug)) {
            $blog = Blog::all();
        } else {
            $blog = Blog::where('slug', $slug)->first();
        }
        if ($blog) {
            return $blog;
        } else {
            return null;
        }
    }
    public function get_blog_by_limit($limit)
    {
        $blogs = Blog::orderBy('created_at', 'desc')->limit($limit)->get();
        if ($blogs) {
            $media = new Media();
            $blogs = $blogs->toArray();
            foreach ($blogs as $key => $value) {
                $img_id = $value['img_id'];
                $images = $media->get_images_by_id($img_id);
                $value['images'] = $images;
                $blogs[$key] = $value;
            }
            return $blogs;
        } else {
            null;
        }
    }
}
