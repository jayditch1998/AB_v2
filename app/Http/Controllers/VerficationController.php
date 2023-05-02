<?php

namespace App\Http\Controllers;

use App\Models\Businesses\BusinessesModel;
use App\Models\Categories\CategoriesModel;
use Illuminate\Http\Request;
use App\Models\PendingOrders\PendingOrdersModel;
use App\Models\SettingModel;
use App\Models\Shortcodes\ShortcodesModel;
use App\Models\Users\UsersModel;
use App\Models\Websites\WebsitesModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class VerficationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->updateBusinessStatus();
      $categories = CategoriesModel::get();
      $websites = WebsitesModel::all();
      $shortcodes = ShortcodesModel::where('enable', '1')->where('show_to_dashboard', '1')->orderBy('position', 'asc');
      $shortcodes = $shortcodes->pluck('business_column') ;
      $users = UsersModel::getActiveUsers()->get();
      $shortcodeInColumn = ['website_id'];
      foreach ($shortcodes as $shortcode){
          if (Schema::hasColumn('businesses', $shortcode))
          {
              array_push($shortcodeInColumn, $shortcode);
          }
      }
      array_push($shortcodeInColumn, 'business_code');
      array_push($shortcodeInColumn, 'status');
      if(empty($shortcodeInColumn))
      {
          return redirect('/admin/shortcodes/create')->with('message', 'No Column Available at the Momment. Start Creating Now.');
      }
      if(auth()->user()->role_id==1){
          $businesses = PendingOrdersModel::select(array_merge($shortcodeInColumn,['id'],['created_at'],['verified'],['pending_orders.*']))->has('website')->where('verified',0)->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->paginate(10);
          return view('pages.admin.verification.index', compact('businesses','shortcodeInColumn','users','websites','categories'));
      }else{
          $businesses = PendingOrdersModel::select(array_merge($shortcodeInColumn,['id'],['created_at'],['verified'],['pending_orders.*']))->has('website')->where('verified',0)->where('user_id',auth()->user()->id)->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->paginate(10);
          return view('pages.user.verification.index', compact('businesses','shortcodeInColumn','users','websites','categories'));
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
        $websiteID = $request->website_id;
        $id = $request->id;
        $business_column = ShortcodesModel::where('enable', '1')->orderBy('position', 'asc')->select('business_column', 'required', 'type', 'full')->get()->toArray();
        $data = [];
        foreach ($business_column as $item){
          if($item['required'] == 1){
            if($item['type'] == 'text'){
              if($item['business_column'] == 'business_name' ){
                  $data = array_merge($data, [$item['business_column'] => [
                      'required',
                       Rule::unique('businesses')->ignore(request()->id),
                  ]]);
              }
                $data = array_merge($data, [$item['business_column'] => 'required']);
            }
            if($item['type'] == 'email'){
                $data = array_merge($data, [$item['business_column'] => 'required | email']);
            }
          }else{
              if($item['type'] == 'text'){
                $data = array_merge($data, [$item['business_column'] => '']);
              }
              if($item['type'] == 'email'){
                $data = array_merge($data, [$item['business_column'] => '']);
              }

          }
          if($item['type'] == 'image'){
              $data = array_merge($data, [$item['business_column'] => '']);
          }
        }
        $data = request()->validate( $data);
        $validatedData =[];
        $x = [];
        foreach ($data as $key => $item){
            if(!is_object($item)){
                $validatedData[$key] = $item;
            }else{
                $full = ShortcodesModel::where('business_column', $key)->first();
                // $public_path = storage_path('app/public/');
                // $save_path = 'uploads/'.time().'-'.$key.$item->getClientOriginalName();
                // $logo = Image::make($item);
                // if($full->full != 1){
                //     $logo = $logo->resize(250,null, function ($constrain){$constrain->aspectRatio();});

                // }
                // $logo = $logo->save($public_path.$save_path);
                // $validatedData = array_merge($validatedData, [$key => $save_path]);
                $public_path = storage_path('app/public/');
                $save_path = 'uploads/'.time().'-'.$key.$item->getClientOriginalName();
                $image = $request->file($key);
                $image_path = $image->move('images', time().'-'.$key.$item->getClientOriginalName());

                $validatedData[$key] = $save_path;
            }
        }

        $business_code = strtolower(str_replace(' ', '-', $validatedData['business_name']));
        $validatedData =array_merge($validatedData, ['business_code' => $business_code]);

        $pending = PendingOrdersModel::findOrFail($id)->update($validatedData);
        dd($pending);
        return redirect('admin/verification');
        }catch(\Throwable $th){
          dd($th->getMessage());
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

    function updateBusinessStatus(){
      $pendingBusinesses = BusinessesModel::where('status', 'pending')->get();
      $time = SettingModel::where('setting_name', 'business_approval')->first();

      $time  = $time->setting_value * 3600;
          foreach ($pendingBusinesses as $pendingBusiness) {
              $timeDeff = strtotime(now())- strtotime($pendingBusiness->created_at);
              if($timeDeff >= $time){
                  BusinessesModel::findOrFail($pendingBusiness->id)->update(['status' => 'approve']);
              }

          }
    }

    public function resendEmail($pending_id){
      $pending = PendingOrdersModel::find($pending_id);

      $user = UsersModel::find($pending->user_id);

      self::sendVerification($pending->verification_code, $user->email);

      return redirect('admin/verification')->with('message', "We re-sent an email verfication to your email. Please verify and wait for the admin's approval.");
  }
  public static function sendVerification($verification_code, $email){

    try{
        // $email = 'balansijayditch@gmail.com';
        // $msg = $request->msg;
        $msg = $verification_code;
        $mail_from = env('MAIL_FROM_ADDRESS');
        $data['msg'] = $msg;
        Mail::send('mail', $data, function($message) use($email, $msg, $mail_from) {
            $message->from('no-reply@agencybuilderdev.io', 'Agency Builder Verification');
            $message->to($email)->subject('Verification');
        });
    }catch(\Exception $e){
        return $e;
    }

}
}
