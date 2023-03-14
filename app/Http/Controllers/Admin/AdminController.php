<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Businesses\BusinessesModel;
use App\Models\User;
use App\Models\Websites\WebsitesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_website = WebsitesModel::get();
        $all_active_website = $all_website->where('status',1)->count();
        $all_inactive_website = $all_website->where('status',0)->count();
        $all_business = BusinessesModel::get();
        $all_inactive_business = $all_business->whereIn('website_id', $all_website->where('status',0)->modelKeys())->count();
        $all_active_business = $all_business->whereIn('website_id', $all_website->where('status',1)->modelKeys())->count();

        return view('pages.admin.dashboard', ['title' => 'Admin Dashboard', 'breadcrumb' => 'This Breadcrumb', 'all_website' => $all_website, 'all_business' => $all_business,'all_active_website' => $all_active_website, 'all_inactive_website' => $all_inactive_website,'all_active_business' => $all_active_business, 'all_inactive_business' => $all_inactive_business]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required',
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
            ]);
            User::updateUser(Arr::except($data, ['id']), $request->id);
            return redirect('admin/dashboard');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
