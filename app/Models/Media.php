<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['parent_id', 'path', 'root_directory', 'dimension'];
    public function children()
    {
        return $this->hasMany(Media::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Media::class, 'parent_id');
    }
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'img_id');
    }

    public static function get_column($id, $column)
    {
        $value = Media::select($column)->where('id', intval($id))->first();
        if (!is_null($value)) {
            return $value[$column];
        } else {
            return null;
        }
    }
    public static function get_media($type = "media")
    {
        $media = Media::all()->reverse();
        $html = '';
        if (count($media) > 0) {
            foreach ($media as $image) {
                $html .= view('admin.partials.gallary_image')->with(['image' => $image->path, 'id' => $image->id])->render();
            }
        }
        return $html;
    }
    public function get_images_by_id($id)
    {
        // $parent_id = Media::find($id)->parent->parent_id;
        // return Media::find($parent_id)->children;
        $parent = Media::select('parent_id')->where('id', $id)->first()['parent_id'];
        return Media::select('path', 'dimension')->where('parent_id', $parent)->get()->toArray();
    }

}
