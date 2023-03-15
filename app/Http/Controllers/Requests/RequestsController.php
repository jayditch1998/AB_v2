<?php

namespace App\Http\Controllers\Requests;

use App\Http\Controllers\Controller;
use App\Models\Requests\RequestsModel;
use Illuminate\Http\Request;
use App\Models\Shortcodes\ShortcodesModel;
use App\Models\Websites\WebsitesModel;
use Illuminate\Support\Facades\Schema;
use App\Models\Users\UsersModel;


class RequestsController extends Controller
{
    public function index(){
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
                $businesses = RequestsModel::select(array_merge($shortcodeInColumn,['id'],['created_at']))->where('verified', 1)->has('website')->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->paginate(10);
            }else{
                $businesses = RequestsModel::select(array_merge($shortcodeInColumn,['id'],['created_at']))->where('verified', 1)->where('user_id', auth()->user()->id)->has('website')->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->paginate(10);
            }

            // dd($businesses, $shortcodeInColumn);
            return view('pages.admin.requests.onlinerequests', compact('businesses','shortcodeInColumn', 'users'));
        }catch(\Throwable $th){
            dd($th->getMessage());
        }
    }
}
