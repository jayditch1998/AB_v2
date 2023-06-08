<?php

namespace App\Http\Controllers\FormFieldOption;

use App\Http\Controllers\Controller;
use App\Models\Websites\WebsitesModel;
use App\Models\Shortcodes\ShortcodesModel;
use App\Models\FormFieldOption\FormFieldOptionModel;

use Illuminate\Http\Request;

class FormFieldOptionController extends Controller
{

    public function index()
    {
        if ((auth()->user()->role->name == "Admin") || (auth()->user()->role->name == "Manager")) {
            $result = [];
            $lastResult = [];
            $userForms = FormFieldOptionModel::get();
            $userForms = $userForms->makeHidden(['id', 'license_key', 'website_id', 'created_at', 'updated_at', 'deleted_at']);
            foreach ($userForms as $key => $userForm) {
                $aCount = 0;
                $dCount = 0;
                $convertToArrayForms = $userForm->toArray();
                foreach ($convertToArrayForms as $form) {
                    if ($form == 1) {
                        $aCount = $aCount + 1;
                    } else {
                        $dCount = $dCount + 1;
                    }
                }
                $result['email'] = $userForm->user_email;
                $result['activated'] = $aCount;
                $result['deactivated'] = $dCount;
                array_push($lastResult, $result);
            }
            return view('pages.admin.formfieldoptions.formfieldoptions', compact('lastResult'));
        }elseif (auth()->user()->role->name == "User") {
            $result = [];
            $lastResult = [];
            $userForms = FormFieldOptionModel::where('user_email',auth()->user()->email)->get();
            $userForms = $userForms->makeHidden(['id', 'license_key', 'website_id', 'created_at', 'updated_at', 'deleted_at']);
            foreach ($userForms as $key => $userForm) {
                $aCount = 0;
                $dCount = 0;
                $convertToArrayForms = $userForm->toArray();
                foreach ($convertToArrayForms as $form) {
                    if ($form == 1) {
                        $aCount = $aCount + 1;
                    } else {
                        $dCount = $dCount + 1;
                    }
                }
                $result['email'] = $userForm->user_email;
                $result['activated'] = $aCount;
                $result['deactivated'] = $dCount;
                array_push($lastResult, $result);
            }
            return view('pages.user.formfieldoptions.formfieldoptions', compact('lastResult'));
        }
        
    }

    public function editUserFormOptions($user)
    {
        $data = FormFieldOptionModel::where('user_email', $user)->get();
        $data = $data->makeHidden(['id', 'user_email', 'license_key', 'website_id', 'created_at', 'updated_at', 'deleted_at']);
        $activated_fields = [];

        foreach ($data as $key => $val) {
            $toArray = json_decode(json_encode($val), true);
            $activated_fields['data'] = $toArray;
        }
        $activated_fields['license_key'] = $data[0]->license_key;
        $LK = $activated_fields['license_key'];
        // return response()->json($activated_fields);

        $html = '';
        foreach ($toArray as $key => $item) {
            $html .= '<tr>                            
                <td>' . ucwords(str_replace('_', ' ', $key)) . '</td>
                    <td>
                        <span class=' . ($item == 1 ? 'alert alert-success p-1 rounded-lg' : 'alert alert-danger p-1 rounded-lg') . '>
                            ' . ($item == 1 ? 'Activated' : 'Deactivated') . '
                        </span>
                    </td>
                        <td class="pl-3">
                            <div class="align-items-baseline">                           
                            ' . ($item == 1 ? '
                                <a 
                                    href="#"
                                    onclick="updateStatus(' . "'$LK'" . ', ' . "'$key'" . ', 0)"
                                    class="text-danger delete-website-btn"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-dash-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                </svg>
                            </a>'
                :
                '<a 
                                href="#"
                                onclick="updateStatus(' . "'$LK'" . ', ' . "'$key'" . ', 1)"
                                class="text-success delete-website-btn"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </a>') . '
                            </div>  
                        </td>  
               ';
        }
        $response['html'] = $html;

        return response()->json($response);
        // return $activated_fields;
        // return view('pages.admin.formfieldoptions.edit_options', ['activated_fields' => $activated_fields]);
    }

    public function update(Request $request)
    {
        try {
            $fkey = $request->fKey;
            $data = FormFieldOptionModel::where('license_key', $request->lKey)->first();
            $data[$fkey] = $request->status;
            $data->save();
            return redirect()->back()->with('message', 'Field: ' . ucwords(str_replace('_', ' ', $formKey)) . ' activated');
        } catch (\Throwable $e) {
            return ($e->getMessage());
        }
    }

    public function deactivateField($formKey, $LKey)
    {
        try {
            $data = FormFieldOptionModel::where('license_key', $LKey)->first();
            $data->$formKey = 0;
            $data->save();
            return redirect()->back()->with('warning', 'Field: ' . ucwords(str_replace('_', ' ', $formKey)) . ' deactivated');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    // public function index(){
    //     $user_email = auth()->user()->email;
    //     $website = WebsitesModel::where('user_id',auth()->user()->id)->get();
    //     if (count($website)==0 && auth()->user()->role_id == 1) {
    //         return redirect('/admin/websites')->with('error', 'Please Create Website First. Thank you');
    //     }elseif(count($website)==0 && (auth()->user()->role_id == 3 || auth()->user()->role_id == 2)){
    //         return redirect('/websites')->with('error', 'Please Create Website First. Thank you');
    //     }else{
    //         foreach ($website as $value) {
    //             $data = FormFieldOptionModel::where('website_id',$value->id)->get();
    //             if(count($data)==0){
    //                 $business_column = ShortcodesModel::where('enable', '1')->orderBy('position', 'asc')->select('business_column', 'required', 'type', 'full')->get()->toArray();

    //                 $data = ['user_email' => auth()->user()->email,'license_key' => auth()->user()->license_key,'website_id' => $value->id];

    //                 foreach ($business_column as $item){
    //                     $data = array_merge($data, [$item['business_column'] => ($item['required'] == 1) ? '1' : '0']);
    //                 }

    //                 $user_onlineforms = FormFieldOptionModel::create($data);
    //             }
    //         }

    //         if(request()->website !=null){
    //             $data = FormFieldOptionModel::where('user_email', $user_email)->where('website_id', request()->website)->first();
    //             $selectedWebsite = $data->website_id;
    //             $data =$data->makeHidden([ 'user_email', 'license_key', 'website_id', 'created_at', 'updated_at', 'deleted_at']);
    //             $activated_fields = [];
    //             $count = 0;

    //             $business_column = ShortcodesModel::where('required', '1')->orderBy('position', 'asc')->select('business_column', 'required', 'type', 'full')->get();

    //             $toArray = json_decode(json_encode($data), true);
    //             $activated_fields['data'] = $toArray;
    //             $activated_fields['id'] = $data->id;
    //             return view('pages.admin.formfieldoptions.formfieldoptions', compact('activated_fields','website','selectedWebsite','business_column'));
    //         }else{
    //             return view('pages.admin.formfieldoptions.formfieldoptions', compact('website'));
    //         }
    //     }
    // }
}
