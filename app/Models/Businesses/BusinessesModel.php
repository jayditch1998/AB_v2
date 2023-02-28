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
        return self::get();
    }
    public function website()
    {
        return $this->belongsTo(WebsitesModel::class);
    }
}