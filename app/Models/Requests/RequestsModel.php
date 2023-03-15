<?php

namespace App\Models\Requests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Websites\WebsitesModel;

class RequestsModel extends Model
{
    use HasFactory;
    protected $table = 'pending_orders';

    public function website()
    {
        return $this->belongsTo(WebsitesModel::class,'website_id');
    }
}
