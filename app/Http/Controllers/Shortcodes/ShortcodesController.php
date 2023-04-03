<?php

namespace App\Http\Controllers\Shortcodes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shortcodes\ShortcodesModel;
use App\Models\ShortcodesCategory\ShortcodesCategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class ShortcodesController extends Controller
{
    public function index(Request $request){
        $shortcodes = ShortcodesModel::orderBy('position', 'asc')
            ->when (!empty($request['category']) && ($request['category'] != "all") , function ($query) use($request){
                return $query->where('shortcode_category_id',$request['category']);
            })
            ->when (!empty($request['q']) , function ($query) use($request){
                return $query->Where('name', 'LIKE', '%' . $request['q'] . '%');
            })
            ->get();
        $shortcode_categories = ShortcodesCategoryModel::all('id', 'name');

        return view('pages.admin.shortcodes.index', compact('shortcodes', 'shortcode_categories'));
    }

    public function wpPluginIndex(){
        $request= request();
        $shortcodes = ShortcodesModel::where('display_on_wp', 1)->orderBy('position', 'asc')
            ->when (!empty($request['category']) && ($request['category'] != "all") , function ($query) use($request){
                return $query->where('shortcode_category_id',$request['category']);
            })
            ->when (!empty($request['q']) , function ($query) use($request){
                return $query->Where('name', 'LIKE', '%' . $request['q'] . '%');
            })
            ->get();
        $shortcode_categories = ShortcodesCategoryModel::all('id', 'name');

        return view('pages.admin.wp-plugins.index', compact('shortcodes', 'shortcode_categories'));
    }

    public function downloadPlugin(){
        $file_path = public_path('wp-plugin/agencybuildershortcodes_dev.zip');
        return response()->download($file_path);
    }

    public function create(Request $request){
        $data = $request->all();
        if (!Schema::hasColumn('businesses', $data['name']) && !ShortcodesModel::where('name', $data['name'])->exists()) {
            
            $Position = ShortcodesModel::max('position') + 1; 
            $name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $data['name'])));                
            $shortcode = '[AgencyBuilder_'.strtolower(str_replace(" ","_", $name)).']';
            
            $newColumn = strtolower(str_replace(" ","_", $data['name']));

            try {
                Schema::table('businesses', function($table) use ($newColumn){
                    $table->string($newColumn)->nullable();
                });

                Schema::table('user_onlineforms', function($table) use ($newColumn){
                    $table->boolean($newColumn)->default('0');
                });
                
                Schema::table('pending_orders', function($table) use ($newColumn){
                    $table->string($newColumn)->nullable();
                });

                ShortcodesModel::create(array_merge($data, [
                    'position' => $Position, 
                    'shortcode' => $shortcode,
                    'business_column'=> $newColumn, 
                ] ));

                return redirect('/admin/shortcodes')->with('message', 'New Shortcode Successfully Added');
            } catch (\Throwable $th) {
                dd($th->getMessage());
                return redirect('admin/shortcodes/')->with('error', $e->getMessage());
            }                
                       
    }else{
        return redirect('/admin/shortcodes')->with('message', $data['name'] . ' already exists in table')->with('exist', '1');
    }
}
}

