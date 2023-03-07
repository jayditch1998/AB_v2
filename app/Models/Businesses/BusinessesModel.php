<?php

namespace App\Models\Businesses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Websites\WebsitesModel;

class BusinessesModel extends Model
{
    use HasFactory;

    protected $table = 'businesses';
    protected $fillable = [
        'website_id',
        'business_name',
        'business_code',
        'status',
        'business_owner',
        'business_email',
        'business_phone',
        'business_address',
        'business_city',
        'business_logo',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'facebook',
        'twitter',
        'deleted_at',
        'price_1',
        'price_2',
        'image1',
        'image2',
        'image3',
        'review1',
        'business_website',
        'business_clinic',
        'business_car',
        'messaging'
    ];

    public static function getAllBusinesses(){
        $select = [
            'businesses.id',
            'users.id as user_id',
            'websites.id as website_id',
            'businesses.business_name',
            'businesses.business_owner',
            'businesses.business_email',
            'businesses.business_code',
            'businesses.business_phone',
            'businesses.business_address',
            'businesses.business_logo',
            'businesses.price_1',
            'businesses.price_2',
            'businesses.review1',
            'businesses.monday',
            'businesses.tuesday',
            'businesses.wednesday',
            'businesses.thursday',
            'businesses.friday',
            'businesses.saturday',
            'businesses.sunday',
            'businesses.facebook',
            'businesses.twitter',
            'businesses.image1',
            'businesses.image2',
            'businesses.image3',
            'businesses.status',
            'websites.url as website_url',
            'users.name as user_name',
            'websites.name as website_name',
        ];
        return self::select($select)
        ->join('websites', 'websites.id', '=', 'businesses.website_id')
        ->join('users', 'users.id', '=', 'websites.user_id')
        ->get();
    }
    public function website()
    {
        return $this->belongsTo(WebsitesModel::class);
    }

    public static function insert($data, $id=null){
        self::updateOrCreate(['id'=>$id], $data);
    }
}