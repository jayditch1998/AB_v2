<?php

namespace App\Http\Controllers\Requests;

use App\Http\Controllers\Controller;
use App\Models\Requests\RequestsModel;
use Illuminate\Http\Request;
use App\Models\Shortcodes\ShortcodesModel;
use App\Models\Websites\WebsitesModel;
use Illuminate\Support\Facades\Schema;
use App\Models\Users\UsersModel;
use App\Models\Businesses\BusinessesModel;
use App\Models\PendingOrders\PendingOrdersModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RequestsController extends Controller
{
    public function index(){
        if ((auth()->user()->role->name == "Admin") || (auth()->user()->role->name == "Manager")) {
            try{
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
                    $businesses = PendingOrdersModel::select(array_merge($shortcodeInColumn,['id'],['created_at']))->where('verified', 1)->has('website')->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get();
                }else{
                    $businesses = PendingOrdersModel::select(array_merge($shortcodeInColumn,['id'],['created_at']))->where('verified', 1)->where('user_id', auth()->user()->id)->has('website')->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get();
                }

                // dd($businesses, $shortcodeInColumn);
                return view('pages.admin.requests.onlinerequests', compact('businesses','shortcodeInColumn', 'users'));
            }catch(\Throwable $th){
                dd($th->getMessage());
            }
        }elseif (auth()->user()->role->name == "User") {
            try{
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
                    return redirect('/online_request/index')->with('message', 'No Column Available at the Momment. Shortcodes Unvailable.');
                }
                if(auth()->user()->role_id==1){
                    $businesses = PendingOrdersModel::select(array_merge($shortcodeInColumn,['id'],['created_at']))->where('verified', 1)->has('website')->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get();
                }else{
                    $businesses = PendingOrdersModel::select(array_merge($shortcodeInColumn,['id'],['created_at']))->where('verified', 1)->where('user_id', auth()->user()->id)->has('website')->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get();
                }

                // dd($businesses, $shortcodeInColumn);
                return view('pages.user.requests.onlinerequests', compact('businesses','shortcodeInColumn', 'users'));
            }catch(\Throwable $th){
                dd($th->getMessage());
            }
        }


    }

    public function approve(Request $request)
    {
        try {
            $pendingData = PendingOrdersModel::find($request->id);
            $pendingDataToArray = $pendingData->toArray();
            $pendingDataToArray['status'] = 'approved';
            $filtered = Arr::except($pendingDataToArray, ['user_id', 'id', 'verified', 'verification_code']);
            $addWebsiteBusiness = BusinessesModel::create($filtered);
            $pendingData->status = 'approved';
            $pendingData->save();
            // if(auth()->user()->role_id==1){
            //     return redirect('admin/online_request')->with('message', 'Pending Orders/Request is Successfully approved');
            // }else{
            //     return redirect('admin/online_request')->with('message', 'Pending Orders/Request is Successfully approved');
            // }

            return response()->json([
                'id' => $request->input('id'),
                'status' => $pendingData->status
              ], 200);

        }catch(\Exception $e){
            return redirect('admin/online_request')->with('message', 'Something went wrong!');
        }
    }

    public function approveAll()
    {
        // dd('yesss!');
        try {
            $pendingData = PendingOrdersModel::where('user_id',auth()->user()->id)->get();
            foreach ($pendingData as $key => $value) {
                $pendingDataToArray = $value->toArray();
                $pendingDataToArray['status'] = 'approved';
                $filtered = Arr::except($pendingDataToArray, ['user_id', 'id', 'verified', 'verification_code']);
                $addWebsiteBusiness = BusinessesModel::create($filtered);
                $value->status = 'approved';
                $value->save();

            }

            if(auth()->user()->role_id==1){
                return redirect('admin/online_request')->with('message', 'All Pending Orders/Request are Successfully approved');
            }else{
                return redirect('online_request')->with('message', 'All Pending Orders/Request are Successfully approved');
            }

        }catch(\Throwable $e){
            return redirect('admin/online_request')->with('message', $e->getMessage());
        }
    }

    public function decline(Request $request)
    {
        PendingOrdersModel::findOrFail($request->id)->delete();
        if(auth()->user()->role_id==1){
            // return redirect('admin/online_request')->with('message', 'Pending Orders/Request is Successfully deleted');
        return response()->json('Success!', 200);
        }else{
            return redirect('/online_request')->with('message', 'Pending Orders/Request is Successfully deleted');
        }

    }

    public function declineAll()
    {
        if(auth()->user()->role_id==1){
            PendingOrdersModel::where('status', 'pending')->delete();
        }else{
            PendingOrdersModel::where('user_id',auth()->user()->id)->delete();
        }
        // $pendingData = RequestsModel::where('user_id',auth()->user()->id)->get();
            // foreach ($pendingData as $key => $value) {
            //     $pendingDataToArray = $value->toArray();
            //     $pendingDataToArray['status'] = 'approved';
            //     $filtered = Arr::except($pendingDataToArray, ['user_id', 'id', 'verified', 'verification_code']);
            //     $value->status = 'declined';
            //     $value->save();
            // }
        if(auth()->user()->role_id==1){
            return redirect('admin/online_request')->with('message', 'All Pending Orders/Request List has been Successfully deleted');
        }else{
            return redirect('admin/online_request')->with('message', 'All Pending Orders/Request List has been Successfully deleted');
        }
    }
}
