<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\CategoriesModel;
use App\Models\Users\UsersModel;

class CategoriesController extends Controller
{
    public function index(){
        try{
            $categories = CategoriesModel::getAllCategories();
            $users = UsersModel::getActiveUsers()->get();   
        }catch(\Throwable $th){
            return $th->getMessage();
        }
        return view('pages.admin.categories.categories', compact('categories', 'users'));
    }

    public function create(Request $request){
        // dd($request->all());
        try{
            $data = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'user_id' => 'required',
            ]);
            CategoriesModel::insert($data);
        return redirect('admin/categories'); 
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }

    public function update(Request $request){
        try{
            $data = $request->validate([
                'id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'user_id' => 'required',
            ]);
            CategoriesModel::insert($data, $request->id);
            return redirect('admin/categories'); 
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }

    public function delete(Request $request){
        try{
            CategoriesModel::deleteWebsite($request->id);
            return redirect('admin/categories'); 
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }
}
