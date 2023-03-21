<?php

namespace App\Models\PendingOrders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Websites\WebsitesModel;

class PendingOrdersModel extends Model
{
    use HasFactory;
    protected $table = 'pending_orders';
    protected $fillable = [
        'website_id',
        'user_id',
        'business_name',
        'business_code',
        'status',
        'created_at',
        'updated_at',
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
        'price_1',
        'price_2',
        'image1',
        'image2',
        'image3',
        'review1',
        'business_website',
        'service1',
        'testfordynamicfunction',
        'demotest',
        'item_1',
        'business_clinic',
        'verified',
        'verification_code',
        'messaging',
        'approved_date',
    ];

    public function website()
    {
        return $this->belongsTo(WebsitesModel::class,'website_id');
    }
}
