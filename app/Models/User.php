<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Websites\WebsitesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'name',
        'email' ,
        'mobile' ,
        'role_id',
        'user_level_id' ,
        'status' ,
        'license_key' ,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function websites(): HasMany
    {
        return $this->hasMany(WebsitesModel::class, 'user_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Userlevel::class, 'user_level_id');
    }

    public static function updateUser($data, $id)
    {
        try {
            $user = self::updateOrCreate(['id' => $id], $data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function deleteUser($id)
    {
        $data = self::find($id);
        $data->deleted_at = date("Y-m-d H:i:s");
        $data->save();
    }
}
