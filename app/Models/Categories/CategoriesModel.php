<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\UsersModel;
class CategoriesModel extends Model
{
    use HasFactory;
    protected $table = 'website_categories';
    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    public static function getAllCategories(){
        return self::orderBy('id', 'desc')->get();
    }

    public static function insert($data, $id=null){
        self::updateOrCreate(['id'=>$id], $data);
    }

    public static function deleteWebsite($id){
        $data = self::find($id);
        $data->deleted_at = date("Y-m-d H:i:s");
        $data->save();
    }

    public function user()
    {
        return $this->belongsTo(UsersModel::class, 'user_id');
    }
}
