<?php

namespace App\Models\ShortcodesCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortcodesCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'shortcode_categories';

    public function shortcodes(){
        return $this->hasMany('App\Shortcodes\ShortcodesModel');
    }
}
