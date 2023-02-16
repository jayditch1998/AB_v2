<?php

namespace App\Models\Websites;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsitesModel extends Model
{
    use HasFactory;
    protected $table = 'websites';

    public static function getWebsitesWithCategories(){
        $select = [
            'websites.id',
            'websites.user_id',
            'websites.name',
            'websites.url',
            'websites.status',
            'websites.business_credit',
            'websites.category_id',
            'wc.name as category_name',
            Db::raw('COUNT(b.id) as business_count')
        ];

        $query = self::select($select)
                    ->leftjoin('website_categories as wc', 'wc.id', '=', 'websites.category_id')
                    ->leftjoin('businesses as b', 'b.website_id', '=', 'websites.id')
                    ->groupBy('websites.id')
                    ->orderBy('id','desc');
        return $query->get();
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
