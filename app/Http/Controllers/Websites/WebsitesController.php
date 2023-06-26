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
    public function index()
    {
        // return $users);
        if ((auth()->user()->role->name == "Admin") || (auth()->user()->role->name == "Manager")) {
            try {
                $data = WebsitesModel::getWebsitesWithCategories();
                $categories = CategoriesModel::get();
                $users = UsersModel::getActiveUsers()->get();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
            return view('pages.admin.websites.websites', compact('data', 'categories', 'users'));
        }elseif (auth()->user()->role->name == "User") {
            try {
                $data = WebsitesModel::getUserWebsitesWithCategories();
                $categories = CategoriesModel::where('user_id',auth()->user()->id)->get();
                $users = UsersModel::getActiveUsers()->where('id',auth()->user()->id)->get();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
            return view('pages.user.websites.websites', compact('data', 'categories', 'users'));
        }

        
    }

    public function create(Request $request)
    {
        // dd($request->all());
        try {
            $data = $request->validate([
                'name' => 'required',
                'category_id' => 'required',
                'url' => 'required',
                'user_id' => 'required',
            ]);
            WebsitesModel::insert($data);
            $category = CategoriesModel::find($request->category_id);
            $user = UsersModel::find($request->user_id);
            return response()->json([
              'name' => $request->input('name'),
              'url' => $request->input('url'),
              'user' => $user->name,
              'category' => $user->name,
              'status' => 'Inactive',
              'business_count' => 0
            ], 200);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            WebsitesModel::deleteWebsite($request->id);
            return redirect('admin/websites');
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
                'category_id' => 'required',
                'url' => 'required',
                'user_id' => 'required',
            ]);
            $website = WebsitesModel::insert($data, $request->id);
            $category = CategoriesModel::find($request->category_id);
            $user = UsersModel::find($request->user_id);
            return response()->json([
              'name' => $request->input('name'),
              'url' => $request->input('url'),
              'user' => $user->name,
              'category' => $user->name,
              'status' => 'Inactive',
              'business_count' => 0,
              'id' => $request->input('id'),
            ], 200);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function edit(WebsitesModel $WebsitesModel)
    {
        return view('pages.admin.websites.websites', compact('WebsitesModel'));
    }
}
