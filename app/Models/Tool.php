<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class Tool extends Model implements Auditable
{
    use HasFactory, Notifiable, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'tool_name', 'tool_slug', 'tool_meta_title',
        'tool_meta_description', 'tool_lang', 'tool_parent', 'tool_content', 'is_home',
    ];
    public function children()
    {
        return $this->hasMany(Tool::class, 'tool_parent');
    }
    public function parent()
    {
        return $this->belongsTo(Tool::class, 'tool_parent');
    }
    public function get_parent_tool($parent_id)
    {
        return Tool::select('tool_name')->where('id', $parent_id)->first()['tool_name'];
    }

}
