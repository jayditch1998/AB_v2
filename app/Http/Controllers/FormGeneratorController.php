<?php

namespace App\Http\Controllers;

use App\Models\FormGenerator;
use App\Models\User;
use App\Models\Websites\WebsitesModel;
use Illuminate\Http\Request;

class FormGeneratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ((auth()->user()->role->name == "Admin") || (auth()->user()->role->name == "Manager")) {
            $websites = WebsitesModel::get();
            if($websites){
                return view('pages.admin.onlineform.index',['title' => 'Admin Dashboard', 'websites' => $websites]);
            }else{
                return view('pages.admin.onlineform.index',['title' => 'Admin Dashboard', 'websites' => $websites]);
            } 
        }elseif (auth()->user()->role->name == "User") {
            $websites = WebsitesModel::where('user_id',auth()->user()->id)->get();
            if($websites){
                return view('pages.user.onlineform.index',['title' => 'Admin Dashboard', 'websites' => $websites]);
            }else{
                return view('pages.user.onlineform.index',['title' => 'Admin Dashboard', 'websites' => $websites]);
            }
        }
        
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
     * @param  \App\Models\FormGenerator  $formGenerator
     * @return \Illuminate\Http\Response
     */
    public function show(FormGenerator $formGenerator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormGenerator  $formGenerator
     * @return \Illuminate\Http\Response
     */
    public function edit(FormGenerator $formGenerator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormGenerator  $formGenerator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormGenerator $formGenerator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormGenerator  $formGenerator
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormGenerator $formGenerator)
    {
        //
    }

    public function generate(Request $request){
        // dd($request->all());
        // $websites = WebsitesModel::where('user_id',auth()->user()->id)->get();
        // if(isset(request()->website)){
        //     $website = WebsitesModel::find($request->website);
        //     $user = User::find($website->user_id);
        //     $website = $website->name;
        //     $LKey = $user->license_key;
        //     return view('pages.admin.onlineform.index',['title' => 'Admin Dashboard', 'websites' => $websites,'website' => $website,'LKey' => $LKey]);
        // }else{
        //     return 'generateOnlineForm Error!';
        // }

        try {
            $data = $request->validate([
                'website' => 'required',
            ]);
            
            $website = WebsitesModel::find($request->input('website'));
            $user = User::find($website->user_id);
            $website = $website->name;
            $LKey = $user->license_key;
            $str = '<iframe src="https://app.agencybuilderdev.io/form/'.$website.'/'.$LKey.'" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
            // return redirect('admin/categories');
            // return response()->json('Success!', 200);
            return response()->json([
              'usrtxt' => $str,
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
