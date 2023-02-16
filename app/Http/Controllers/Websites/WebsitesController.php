<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Websites\WebsitesModel;

class WebsitesController extends Controller
{
    public function index(){
        // $data = WebsitesModel::with('websitesCategory');
        try{
            $data = WebsitesModel::getWebsitesWithCategories();
        }catch(\Throwable $th){
            return $th->getMessage();
        }
        // return $data;
        return view('pages.admin.websites.websites', compact('data'));
    }
}
