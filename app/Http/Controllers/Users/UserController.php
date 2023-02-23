<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Userlevel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $users = User::all();
            $roles = Role::all();
            $levels = Userlevel::all();
            
        }catch(\Throwable $th){
            return $th->getMessage();
        }
      
        return view('pages.admin.users.index', compact('users','roles','levels'));
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
        try{
            $data = $request->validate([
                'id' => 'required',
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                'role_id' => 
                    'required'
                    
                ,
                'user_level_id' => 
                    'required'
                    
                ,
                'status' => 'required',
                'license_key' => 'required',
            ]);
            $website_credit = Userlevel::find($request->user_level_id);
            User::updateUser(array_merge(Arr::except($data, ['id']), ['website_credit' => $website_credit->website_limit]), $request->id);
            return redirect('admin/users'); 
        }catch(\Throwable $th){
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
