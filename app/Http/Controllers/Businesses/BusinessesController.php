<?php

namespace App\Http\Controllers\Businesses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Websites\WebsitesModel;
use App\Models\Categories\CategoriesModel;
use App\Models\Users\UsersModel;
use App\Models\Businesses\BusinessesModel;
use App\Models\Userlevel;
use App\Models\Shortcodes\ShortcodesModel;
use App\Models\PendingOrders\PendingOrdersModel;
use Illuminate\Validation\Rule;

class BusinessesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
          $businesses = BusinessesModel::getAllBusinesses();
          $categories = CategoriesModel::get();
          $websites = WebsitesModel::get();
          $users = UsersModel::getActiveUsers()->get();
          // return $businesses;
            
        }catch(\Throwable $th){
          return $th->getMessage();
        }
        return view('pages.admin.businesses.businesses', compact('businesses', 'categories', 'users', 'websites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      try{
        $websiteID = $request->website_id;
        $Userlevel = Userlevel::find(auth()->user()->user_level_id);
        $Userlevel_approval_hours = $Userlevel->approval_hours;
        $website = WebsitesModel::find($websiteID);
  
        $business_credit = $website->business_credit;
                 
        $shortcode = ShortcodesModel::where('enable', '1')->orderBy('position', 'asc')->select('business_column', 'type', 'required')->get()->toArray();
        
        $data = [];
        foreach ($shortcode as $item){
            //dd($data);
            if($item['type'] == 'text'){
                $data = array_merge($data, [$item['business_column'] => ($item['required'] == 1) ? 'required' : '' ]);
            }else{
                $data = array_merge($data, [$item['business_column'] => ['image' => 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:512']]);
            }
        }
        $data = request()->validate( $data);
        // dd($data);
  
        $validatedData =[];
        foreach ($data as $key => $item){
            if(!is_object($item)){
                $validatedData[$key] = $item;
            }else{
                    $full = ShortcodesModel::where('business_column', $key)->first();
  
                    $public_path = storage_path('app/public/');
                    $save_path = 'uploads/'.time().'-'.$key.$item->getClientOriginalName();
                    $image = $request->file($key);
                    
                    // $logo = Image::make($item);
                    // if($full->full != 1){ 
                    //     $logo = $logo->resize(250,null, function ($constrain){$constrain->aspectRatio();});
                    // }
                    // $logo = $logo->save($public_path.$save_path);
                    // dd($image);

                    // \Log::info($key);
                    $image_path = $image->move('images', time().'-'.$key.$item->getClientOriginalName());
  
                    $validatedData[$key] = $save_path;                    
            }
        }
        
        $business_code = self::slugify($validatedData['business_name']);
  
        if($Userlevel_approval_hours > 0){
            $status = 'pending';
            $validatedData = array_merge($validatedData, ['website_id' => $websiteID, 'business_code' => $business_code, 'status' => $status, 'user_id' => auth()->user()->id]);
            PendingOrdersModel::create($validatedData);
        }else{
            $status = 'approve';
            $validatedData = array_merge($validatedData, ['website_id' => $websiteID, 'business_code' => $business_code, 'status' => $status]);
            BusinessesModel::create($validatedData);
        }
        return redirect('admin/businesses'); 
      }catch(\Throwable $th){
        dd($th->getMessage());
      }
    }

    public static function slugify($text, string $divider = '-')
    {
      // replace non letter or digits by divider
      $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, $divider);

      // remove duplicate divider
      $text = preg_replace('~-+~', $divider, $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
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
              $full = Shortcode::where('business_column', $key)->first();
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
      BusinessesModel::findOrFail($id)->update($validatedData);
      return redirect('admin/businesses'); 
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
}
