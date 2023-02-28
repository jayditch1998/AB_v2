<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Userlevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::all();
            $roles = Role::all();
            $levels = Userlevel::all();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return view('pages.admin.users.index', compact('users', 'roles', 'levels'));
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
        try {
            

            $data = $this->validate($request,[
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                'role_id' => 
                    'required'
                    
                ,
                'user_level_id' => 
                    'required'
                    
                ,
                'password' => 
                    'required'
                    
                ,
                'status' => 'required',
            ]);
            
            $userlevel = Userlevel::findOrFail($data['user_level_id']);
            //dd($userlevel->business_limit);
            $dt = Carbon::now();

            $user = User::create([
                'user_level_id' => $data['user_level_id'],
                'role_id' => $data['role_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'status' => $data['status'],
                'website_credit' => $userlevel->website_limit,
                'expired_at' => $dt->addMonth()->isoFormat('Y-M-D h:mm:ss'),
                // 'license_key' => $license_key,
                'password' => Hash::make($data['password']),
            ]);
            
            

            // $admin = User::whereHas('role', function ($query) {

            //     $query->where('name', '=', 'Admin');
            // })->get();
            // foreach ($admin as $key) {
            //     $key->notify(new \App\Notifications\NewUserAdminNotify());
            // }

            // $admin->sendEmailVerificationNotification();







            return redirect('admin/users')->withErrors($data,'user');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
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
                'role_id' =>
                'required',
                'user_level_id' =>
                'required',
                'status' => 'required',
                'license_key' => 'required',
            ]);
            $website_credit = Userlevel::find($request->user_level_id);
            User::updateUser(array_merge(Arr::except($data, ['id']), ['website_credit' => $website_credit->website_limit]), $request->id);
            return redirect('admin/users');
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
    public function destroy(Request $request)
    {
        try{
            User::deleteUser($request->id);
            return redirect('admin/users'); 
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }
}
