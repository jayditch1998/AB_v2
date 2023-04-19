<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\CategoriesModel;
use App\Models\Role;
use App\Models\Websites\WebsitesModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UsersModel extends Model
{
    use HasFactory;
    protected $table = 'users';

    public static function getActiveUsers(){
        $select = [
            'users.id',
            'users.name',
            'users.email'

        ];
        $users = self::select($select)->where('status', 'Active');

        return $users;
    }

    public function websites(): HasMany
    {
        return $this->hasMany(WebsitesModel::class, 'user_id');
    }

    public function categories()
    {
        return $this->hasMany(CategoriesModel::class, 'user_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
