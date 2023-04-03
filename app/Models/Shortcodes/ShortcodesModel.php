<?php

namespace App\Models\Shortcodes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortcodesModel extends Model
{
    use HasFactory;
    protected $table = 'shortcodes';
    protected $fillable = [
        'shortcode_category_id',
        'name',
        'shortcode',
        'type',
        'required',
        'enable',
        'show_to_dashboard',
        'position',
        'business_column',
        'full',
        'display_on_wp',
    ];

    public function shortcodeCategory()
    {
        return $this->belongsTo('App\Models\ShortcodesCategory\ShortcodesCategoryModel', 'shortcode_category_id');
    }

    public function user_onlineform()
    {
        return $this->hasMany(UserOnlineform::class,'short_code_id');
    }
}
