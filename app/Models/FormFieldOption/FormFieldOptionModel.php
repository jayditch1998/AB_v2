<?php

namespace App\Models\FormFieldOption;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldOptionModel extends Model
{
    use HasFactory;
    protected $table = 'user_onlineforms';
    protected $fillable = [
        'user_email',
        'license_key',
        'website_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function shortcodes(){
        return $this->belongsTo(Shortcode::class,'short_code_id');
    }
}
