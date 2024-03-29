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
    try {
      $businesses = BusinessesModel::getAllBusinesses();
      $categories = CategoriesModel::get();
      $websites = WebsitesModel::get();
      $users = UsersModel::getActiveUsers()->get();
      // return $businesses;

    } catch (\Throwable $th) {
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
    // dd($request->all());
    try {
      $websiteID = $request->website_id;
      $Userlevel = Userlevel::find(auth()->user()->user_level_id);
      $Userlevel_approval_hours = $Userlevel->approval_hours;
      $website = WebsitesModel::find($websiteID);
      $user = UsersModel::find($request->user_id);

      $business_credit = $website->business_credit;

      $shortcode = ShortcodesModel::where('enable', '1')->orderBy('position', 'asc')->select('business_column', 'type', 'required')->get()->toArray();

      $data = [];
      \DB::beginTransaction();
      foreach ($shortcode as $item) {
        $data = array_merge($data, [$item['business_column'] => ($item['required'] == 1) ? 'required' : '']);
      }
      $data = request()->validate($data);

      $validatedData = [];
      foreach ($data as $key => $item) {
        if (!is_object($item)) {
          $validatedData[$key] = $item;
        } else {
          $full = ShortcodesModel::where('business_column', $key)->first();

          $public_path = storage_path('app/public/');
          $save_path = 'uploads/' . time() . '-' . $key . $item->getClientOriginalName();
          $image = $request->file($key);
          $image_path = $image->move('images', time() . '-' . $key . $item->getClientOriginalName());

          $validatedData[$key] = $save_path;
        }
      }

      $business_code = self::slugify($validatedData['business_name']);

      if ($Userlevel_approval_hours > 0) {
        $status = 'pending';
        $validatedData = array_merge($validatedData, ['website_id' => $websiteID, 'business_code' => $business_code, 'status' => $status, 'user_id' => auth()->user()->id]);
        $businessModel = PendingOrdersModel::create($validatedData);
      } else {
        $status = 'approved';
        $validatedData = array_merge($validatedData, ['website_id' => $websiteID, 'business_code' => $business_code, 'status' => $status]);
        $businessModel = BusinessesModel::create($validatedData);
      }
      return response()->json([
        'user' => $user->name,
        'website' => $website->name,
        'business_name' => $request->business_name,
        'business_owner' => $request->business_owner,
        'business_email' => $request->business_email,
        'code' => $businessModel->business_code,
        'status' => $businessModel->status,
        'url' => $website->url
      ], 200);
      \DB::commit();
    } catch (\Throwable $th) {
      \DB::rollback();
      return response()->json($th->getMessage(), 500);
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
    try {
      $websiteID = $request->website_id;
      $id = $request->id;
      $business_column = ShortcodesModel::where('enable', '1')->orderBy('position', 'asc')->select('business_column', 'required', 'type', 'full')->get()->toArray();
      $website = WebsitesModel::find($websiteID);
      $user = UsersModel::find($request->user_id);
      $data = [];

      foreach ($business_column as $item) {
        if ($item['required'] == 1) {
          if ($item['type'] == 'text') {
            if ($item['business_column'] == 'business_name') {
              $data = array_merge($data, [$item['business_column'] => [
                'required',
                Rule::unique('businesses')->ignore(request()->id),
              ]]);
            }
            $data = array_merge($data, [$item['business_column'] => 'required']);
          }
          if ($item['type'] == 'email') {
            $data = array_merge($data, [$item['business_column'] => 'required | email']);
          }
        } else {
          if ($item['type'] == 'text') {
            $data = array_merge($data, [$item['business_column'] => '']);
          }
          if ($item['type'] == 'email') {
            $data = array_merge($data, [$item['business_column'] => '']);
          }
        }
        if ($item['type'] == 'image') {
          $data = array_merge($data, [$item['business_column'] => '']);
        }
      }
      $data = request()->validate($data);
      $validatedData = [];
      $x = [];
      foreach ($data as $key => $item) {
        if (!is_object($item)) {
          $validatedData[$key] = $item;
        } else {
          $full = ShortcodesModel::where('business_column', $key)->first();
          $public_path = storage_path('app/public/');
          $save_path = 'uploads/' . time() . '-' . $key . $item->getClientOriginalName();
          $image = $request->file($key);
          $image_path = $image->move('images', time() . '-' . $key . $item->getClientOriginalName());

          $validatedData[$key] = $save_path;
        }
      }
      $business_code = strtolower(str_replace(' ', '-', $validatedData['business_name']));
      $validatedData = array_merge($validatedData, ['business_code' => $business_code]);
      if ($id) $businessModel = BusinessesModel::findOrFail($id)->update($validatedData);
      // dd($businessModel);
      return response()->json([
        'id' => $id,
        'user' => $user->name,
        'website' => $website->name,
        'business_name' => $request->business_name,
        'business_owner' => $request->business_owner,
        'business_email' => $request->business_email,
        'code' => $business_code,
        'status' => 'approved',
        'url' => $website->url
      ], 200);
    } catch (\Throwable $th) {
      return response()->json($th->getMessage(), 500);
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
