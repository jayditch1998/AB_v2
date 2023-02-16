<?php

namespace App\Models\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends Model
{
    use HasFactory;
    protected $table = 'website_categories';

    public function websites(){
        return $this->hasMany(WebsitesModel::class);
    }
}
