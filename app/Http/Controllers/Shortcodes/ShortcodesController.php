<?php

namespace App\Http\Controllers\Shortcodes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shortcodes\ShortcodesModel;
use App\Models\ShortcodesCategory\ShortcodesCategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class ShortcodesController extends Controller
{
    public function index(Request $request)
    {


        if (auth()->user()->role->name == "Admin") {
            $shortcodes = ShortcodesModel::orderBy('position', 'asc')
                ->when(!empty($request['category']) && ($request['category'] != "all"), function ($query) use ($request) {
                    return $query->where('shortcode_category_id', $request['category']);
                })
                ->when(!empty($request['q']), function ($query) use ($request) {
                    return $query->Where('name', 'LIKE', '%' . $request['q'] . '%');
                })
                ->get();
            $shortcode_categories = ShortcodesCategoryModel::all('id', 'name');

            return view('pages.admin.shortcodes.index', compact('shortcodes', 'shortcode_categories'));
        } elseif (auth()->user()->role->name == "User") {
            $shortcodes = ShortcodesModel::orderBy('position', 'asc')
                ->when(!empty($request['category']) && ($request['category'] != "all"), function ($query) use ($request) {
                    return $query->where('shortcode_category_id', $request['category']);
                })
                ->when(!empty($request['q']), function ($query) use ($request) {
                    return $query->Where('name', 'LIKE', '%' . $request['q'] . '%');
                })
                ->get();

            return view('pages.admin.shortcodes.index', compact('shortcodes'));
        }
    }

    public function wpPluginIndex()
    {
        $request = request();
        if (auth()->user()->role->name == "Admin") {
            $shortcodes = ShortcodesModel::where('display_on_wp', 1)->orderBy('position', 'asc')
                ->when(!empty($request['category']) && ($request['category'] != "all"), function ($query) use ($request) {
                    return $query->where('shortcode_category_id', $request['category']);
                })
                ->when(!empty($request['q']), function ($query) use ($request) {
                    return $query->Where('name', 'LIKE', '%' . $request['q'] . '%');
                })
                ->get();
            $shortcode_categories = ShortcodesCategoryModel::all('id', 'name');

            return view('pages.admin.wp-plugins.index', compact('shortcodes', 'shortcode_categories'));
        } elseif (auth()->user()->role->name == "User") {
            $shortcodes = ShortcodesModel::where('display_on_wp', 1)->orderBy('position', 'asc')
                ->when(!empty($request['category']) && ($request['category'] != "all"), function ($query) use ($request) {
                    return $query->where('shortcode_category_id', $request['category']);
                })
                ->when(!empty($request['q']), function ($query) use ($request) {
                    return $query->Where('name', 'LIKE', '%' . $request['q'] . '%');
                })
                ->get();

            return view('pages.user.shortcodes.shortcodes', compact('shortcodes'));
        }
    }

    public function downloadPlugin()
    {
        $file_path = public_path('wp-plugin/agencybuildershortcodes_dev.zip');
        return response()->download($file_path);
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $data = $request->all();

        if (!Schema::hasColumn('businesses', $data['name']) && !ShortcodesModel::where('name', $data['name'])->exists()) {

            $Position = ShortcodesModel::max('position') + 1;
            $name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $data['name'])));
            $shortcode = '[AgencyBuilder_' . strtolower(str_replace(" ", "_", $name)) . ']';

            $newColumn = strtolower(str_replace(" ", "_", $data['name']));

            try {
                Schema::table('businesses', function ($table) use ($newColumn) {
                    $table->string($newColumn)->nullable();
                });

                Schema::table('user_onlineforms', function ($table) use ($newColumn) {
                    $table->boolean($newColumn)->default('0');
                });

                Schema::table('pending_orders', function ($table) use ($newColumn) {
                    $table->string($newColumn)->nullable();
                });
                $shortcodeModel = ShortcodesModel::create(array_merge($data, [
                    'position' => $Position,
                    'shortcode' => $shortcode,
                    'business_column' => $newColumn,
                ]));
                $shortcode_category = ShortcodesCategoryModel::find($request->shortcode_category_id);
                return response()->json([
                    'name' => $request->input('name'),
                    'shortcode' => $shortcode,
                    'shortcode_category' => $shortcode_category->name,
                    'required' => $request->required,
                    'enable' => $request->enable,
                    'position' => $shortcodeModel->position,
                ]);
                // return redirect('/admin/shortcodes')->with('message', 'New Shortcode Successfully Added');
            } catch (\Throwable $th) {
                dd($th->getMessage());
                return redirect('admin/shortcodes/')->with('error', $th->getMessage());
            }
        } else {
            return redirect('/admin/shortcodes')->with('message', $data['name'] . ' already exists in table')->with('exist', '1');
        }
    }

    public function update(Request $request)
    {

        $data = request()->validate([
            'name' => ['required '],
            'shortcode_category_id' => 'required',
            'type' => 'required',
            'position' => '',
            'full' => '',

        ]);
        $shortcode_id = $request->id;
        $enable = (request()->get('enable') ? 1 : 0);
        $full = (request()->get('full') ? 1 : 0);

        $show_to_dashboard = (request()->get('show_to_dashboard') ? 1 : 0);
        $display_on_wp = (request()->get('display_on_wp') ? 1 : 0);
        $required = (request()->get('required') ? 1 : 0);
        $oldColumn = request('oldColumn');
        $newColumn  = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $data['name'])));
        //$newColumn = strtolower(str_replace(" ","_", $data['name']));
        $shortcode = '[AgencyBuilder_' . $newColumn . ']';

        try {
            DB::beginTransaction();
            Schema::table('businesses', function($table) use ($oldColumn, $newColumn){
                $table->renameColumn($oldColumn, $newColumn);
            });
            Schema::table('user_onlineforms', function(Blueprint $table) use ($oldColumn, $newColumn){
                $table->renameColumn($oldColumn, $newColumn);
            });
            $shortcodeModel = ShortcodesModel::findOrFail($shortcode_id)->update(array_merge($data, [
                'business_column' => $newColumn,
                'shortcode' => $shortcode,
                'enable' => $enable,
                'show_to_dashboard' => $show_to_dashboard,
                'display_on_wp' => $display_on_wp,
                'required' => $required,
                'full' => $full,
            ]));
            
            $shortcode_category = ShortcodesCategoryModel::find($request->shortcode_category_id);
            return response()->json([
                'id' => $request->input('id'),
                'name' => $request->input('name'),
                'shortcode' => $shortcode,
                'shortcode_category' => $shortcode_category->name,
                'required' => $request->required,
                'enable' => $request->enable,
                'position' => $request->position,
                'show_to_dashboard' => $request->show_to_dashboard,
                'display_on_wp' => $request->display_on_wp,
                'full' => $request->full,
            ]);
            DB::commit();
            // return redirect('/admin/shortcodes')->with('message', 'Shortcode Successfully updated');
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 500);
            DB::rollBack();
        }
    }
}
