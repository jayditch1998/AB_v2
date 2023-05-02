<?php

namespace App\Models\Websites;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsitesModel extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'websites';
    protected $fillable = [
        'user_id',
        'name',
        'url',
        'status',
        'business_credit',
        'category_id'
    ];
    // public $dates = [
    //     'created_at',
    //     'deleted_at'
    // ];

    public static function getWebsitesWithCategories(){
        $select = [
            'websites.id',
            'websites.user_id',
            'websites.category_id',
            'websites.name',
            'websites.url',
            'websites.status',
            'websites.business_credit',
            'websites.business_credit',
            'websites.deleted_at',
            'wc.name as category_name',
            Db::raw('COUNT(b.id) as business_count')
        ];

        $query = self::select($select)
                    ->leftjoin('website_categories as wc', 'wc.id', '=', 'websites.category_id')
                    ->leftjoin('businesses as b', 'b.website_id', '=', 'websites.id')
                    ->whereNull('websites.deleted_at')
                    ->groupBy('websites.id')
                    ->orderBy('id','desc');
        return $query->get();
    }

    public static function getUserWebsitesWithCategories(){
        $select = [
            'websites.id',
            'websites.user_id',
            'websites.category_id',
            'websites.name',
            'websites.url',
            'websites.status',
            'websites.business_credit',
            'websites.business_credit',
            'websites.deleted_at',
            'wc.name as category_name',
            Db::raw('COUNT(b.id) as business_count')
        ];

        $query = self::select($select)
                    ->where('websites.user_id',auth()->user()->id)
                    ->leftjoin('website_categories as wc', 'wc.id', '=', 'websites.category_id')
                    ->leftjoin('businesses as b', 'b.website_id', '=', 'websites.id')
                    ->whereNull('websites.deleted_at')
                    ->groupBy('websites.id')
                    ->orderBy('id','desc');
        return $query->get();
    }

    public static function insert($data, $id=null){
        self::updateOrCreate(['id'=>$id], array_merge($data, ['business_credit'=>50]));
    }

    public static function deleteWebsite($id){
        $data = self::find($id);
        $data->deleted_at = date("Y-m-d H:i:s");
        $data->save();
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function pendingOrders()
    // {
    //     return $this->hasMany(pendingOrders::class,'website_id');
    // }
}
