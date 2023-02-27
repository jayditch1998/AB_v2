<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userlevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'website_limit',
        'business_limit',
        'approval_limit',
        'approval_hours' ,
        
    ];

    public static function insert($data, $id){
        self::updateOrCreate(['id'=>$id], $data);
    }

    public static function deleteLevel($id)
    {
        $data = self::find($id);
        $data->delete();
    }
}
