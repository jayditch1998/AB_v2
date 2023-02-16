<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
