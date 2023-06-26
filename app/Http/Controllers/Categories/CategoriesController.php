<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\CategoriesModel;
use App\Models\Users\UsersModel;

class CategoriesController extends Controller
{
    public function index()
    {
        if ((auth()->user()->role->name == "Admin") || (auth()->user()->role->name == "Manager")) {
            try {

                $categories = CategoriesModel::getAllCategories();
                $users = UsersModel::getActiveUsers()->get();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        } elseif (auth()->user()->role->name == "User") {
            try {

                $categories = CategoriesModel::where('user_id',auth()->user()->id)->get();
                $users = UsersModel::getActiveUsers()->where('id',auth()->user()->id)->get();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
        return view('pages.admin.categories.categories', compact('categories', 'users'));
    }

    public function create(Request $request)
    {
        // dd($request->all());
        try {
            $data = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'user_id' => 'required',
            ]);
            CategoriesModel::insert($data);
            $user = UsersModel::find($request->input('user_id'));
            // return redirect('admin/categories');
            // return response()->json('Success!', 200);
            return response()->json([
              'name' => $request->input('name'),
              'description' => $request->input('description'),
              'user' => $user->name
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'user_id' => 'required',
            ]);
            CategoriesModel::insert($data, $request->id);
            $user = UsersModel::find($request->user_id);
            return response()->json([
              'id' => $request->id,
              'name' => $request->input('name'),
              'description' => $request->input('description'),
              'user' => $user->name,
              'user_id'=> $user->id
          ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            CategoriesModel::deleteWebsite($request->id);
            return redirect('admin/categories');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
