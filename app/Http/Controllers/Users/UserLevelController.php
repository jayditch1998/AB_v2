<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Userlevel;
use Illuminate\Http\Request;

class UserLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $levels = Userlevel::all();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return view('pages.admin.users-settings.index', compact('levels'));
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
        try{
            $data = $request->validate([
                'name' => 'required',
                'website_limit' => 'required',
                'business_limit' => 'required',
                'approval_limit' => 'required',
                'approval_hours' => 'required',
            ]);
            Userlevel::insert($data,null);
        return redirect('admin/user-levels'); 
        }catch(\Throwable $th){
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
        try{
            $data = $request->validate([
                'id' => 'required',
                'name' => 'required',
                'website_limit' => 'required',
                'business_limit' => 'required',
                'approval_limit' => 'required',
                'approval_hours' => 'required',
            ]);
            
            Userlevel::insert($data,$data['id']);
        return redirect('admin/user-levels'); 
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
    public function destroy(Request $request)
    {
        try{
            Userlevel::deleteLevel($request->id);
            return redirect('admin/user-levels'); 
        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }
}
