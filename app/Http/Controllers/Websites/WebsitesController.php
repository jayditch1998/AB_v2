<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Websites\WebsitesModel;
use App\Models\Categories\CategoriesModel;
use App\Models\User;
use App\Models\Users\UsersModel;

class WebsitesController extends Controller
{
    public function index(){
        // return $users);
        try{
            $data = WebsitesModel::getWebsitesWithCategories();
            $categories = CategoriesModel::get();
            $users = UsersModel::getActiveUsers()->get();
            
        }catch(\Throwable $th){
            return $th->getMessage();
        }
        
        return view('pages.admin.websites.websites', compact('data', 'categories', 'users'));
    }

    public function create(Request $request){
        // dd($request->all());
        try{
            $data = $request->validate([
                'name' => 'required',
                'category_id' => 'required',
                'url' => 'required',
                'user_id' => 'required',
            ]);
            WebsitesModel::insert($data);
        return redirect('admin/websites'); 
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }

    public function delete(Request $request){
        try{
            WebsitesModel::deleteWebsite($request->id);
            return redirect('admin/websites'); 
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }

    public function update(Request $request){
        try{
            $data = $request->validate([
                'id' => 'required',
                'name' => 'required',
                'category_id' => 'required',
                'url' => 'required',
                'user_id' => 'required',
            ]);
            WebsitesModel::insert($data, $request->id);
            return redirect('admin/websites'); 
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }

    public function edit(WebsitesModel $WebsitesModel){
        return view('pages.admin.websites.websites', compact('WebsitesModel'));
    }
}
