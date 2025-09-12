<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Settings As MSettings;
use App\Models\Page As Page;
use App\Models\Payment_gateway;

class Settings extends Controller
{
    public function basic(){
        valid_session('settings','basic');
        return view('backend.settings.basic');
    }
     public function application(){
        valid_session('settings','application');
        return view('backend.settings.application');
    }
    public function update_basic(Request $request){
        $status = false;
        $type = 'error';
        $title = translate('Basic Settings');
        $msg = translate('Invalid Request');
       
        $validator = Validator::make($request->all(), [
            'app_title' => 'required',
            'app_short_title' => 'required',
            'app_language' => 'required',
            'app_timezone' => 'required',
            'app_date_format' => 'required',
            'app_time_format' => 'required',
            'app_footer_credit' => 'required'
        ]);
        $attrNames = [
            'app_title' => translate('App Title'),
            'app_short_title' => translate('App Short Title'),
            'app_language' => translate('App Language'),
            'app_timezone' => translate('App Timezone'),
            'app_date_format' => translate('App Date Format'),
            'app_time_format' => translate('App Time Format'),
            'app_footer_credit' => translate('App Footer Credit'),
            'app_disable_password_reset' => translate('Disable Password Reset'),
            'app_disable_registration' => translate('Disable Registration'),
            'app_disable_google_font' => translate('Disable Google Font')
        ];
        $validator->setAttributeNames($attrNames); 
        if ($validator->fails()) {
            return response()->json([
                'status' => $status,
                'type' => $type,
                'title'  => $title,
                'message'  => $validator->errors()->all()
            ]);
        }
        
        try {
            DB::beginTransaction();
            
            $ui = ['app_title', 'app_short_title', 'app_language', 'app_timezone', 'app_date_format', 'app_time_format', 'app_footer_credit'];
            foreach ($ui as $key ){
                MSettings::where('key', $key)->update(['value' => $request[$key]]);
            }

            $ui = ['app_disable_password_reset','app_disable_registration','app_disable_google_font'];
            foreach ($ui as $key) {
                $val = 'off';
                if($request[$key]=='on'){
                    $val = 'on';
                }
                MSettings::where('key', $key)->update(['value' => $val]);
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'type' => 'success',
                'title'  => $title,
                'message'  => translate('Basic Settings Updated Successfully'),
                'url'  => route('admin.clear_cache')
            ]);

        } catch(\Exception $exp) {
            DB::rollBack();

            return response([
                'status' => false,
                'type' => 'error',
                'title'  => $title,
                'message' => $msg
                //'message' => $exp->getMessage()
            ]);
        }
    }
    public function theme(){
        valid_session('settings','theme');
        return view('backend.settings.theme');
    }
    public function update_theme(Request $request){
        $status = false;
        $type = 'error';
        $title = translate('Theme Settings');
        $msg = translate('Invalid Request');
        
        // print_r($request->all()); die;
        if ($image = $request->file('app_logo')) {
            $destinationPath = public_path('images/');
            !is_dir($destinationPath) && mkdir($destinationPath, 0777, true);
            $logoImage = 'logo' . ".png";
            // $logoImage = 'logo' . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $logoImage);
        }
        else if ($image = $request->file('app_favicon')) {
            $destinationPath = public_path('images/');
            !is_dir($destinationPath) && mkdir($destinationPath, 0777, true);
            $logoImage = 'favicon' . ".png";
            // $logoImage = 'logo' . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $logoImage);
        }
        $validator = Validator::make($request->all(), [
            'app_primary_color' => 'required',
            'app_secondary_color' => 'required',
            'app_menubar' => 'required'
        ]);
        $attrNames = [
            'app_primary_color' => translate('App Primary Color'),
            'app_secondary_color' => translate('App Secondary Color'),
            'app_menubar' => translate('App Menubar'),
            'app_rtl_mode' => translate('App RTL Mode')
        ];
        $validator->setAttributeNames($attrNames); 
        if ($validator->fails()) {
            return response()->json([
                'status' => $status,
                'type' => $type,
                'title'  => $title,
                'message'  => $validator->errors()->all()
            ]);
        }
        
        try {
            DB::beginTransaction();
            
            $ui = ['app_primary_color', 'app_secondary_color', 'app_menubar'];
            foreach ($ui as $key ){
                MSettings::where('key', $key)
                    ->update(['value' => $request[$key]]);
            }

            $ui = ['app_rtl_mode'];
            foreach ($ui as $key) {
                $val = $request[$key]=='on' ? 'on' : 'off';
                MSettings::where('key', $key)
                    ->update(['value' => $val]);
            } 
            DB::commit();
            return response()->json([
                'status' => true,
                'type' => 'success',
                'title'  => $title,
                'message'  => translate('Basic Settings Updated Successfully'),
                'url'  => route('admin.clear_cache')
            ]);

        } catch(\Exception $exp) {
            DB::rollBack();

            return response([
                'status' => false,
                'type' => 'error',
                'title'  => $title,
                'message' => $msg
                //'message' => $exp->getMessage()
            ]);
        }
    }
public function update_application(Request $request)
{
    $validator = Validator::make($request->all(), [
        'front_page_access' => 'required|in:on,off',
        'app_maintenance_mode' => 'required|in:on,off',
        'app_maintenance_mode_details.phone' => 'required|string',
        'app_maintenance_mode_details.email' => 'required|string|email',
        'app_maintenance_mode_details.address' => 'required|string',
        'app_maintenance_mode_details.map' => 'nullable|string',
    ]);
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'type' => 'error',
            'message' => $validator->errors()->all()
        ]);
    }
    try {
        DB::beginTransaction();
        MSettings::where('key', 'front_page_access')->update(['value' => $request->input('front_page_access')]);
           MSettings::where('key', 'terms_and_conditions_page')->update(['value' => $request->input('terms_and_conditions_page')]);
               MSettings::where('key', 'return_refund_and_cancellation_policy_page')->update(['value' => $request->input('return_refund_and_cancellation_policy_page')]);
                   MSettings::where('key', 'privacy_policy_page')->update(['value' => $request->input('privacy_policy_page')]);
                       MSettings::where('key', 'disclaimer_page')->update(['value' => $request->input('disclaimer_page')]);
        MSettings::where('key', 'app_maintenance_mode')->update(['value' => $request->input('app_maintenance_mode')]);
        $details = [
            'phone' => $request->input('app_maintenance_mode_details.phone'),
            'email' => $request->input('app_maintenance_mode_details.email'),
            'address' => $request->input('app_maintenance_mode_details.address'),
            'map' => $request->input('app_maintenance_mode_details.map'),
        ];
        MSettings::where('key', 'app_maintenance_mode_details')->update(['value' => json_encode($details)]);
        DB::commit();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => translate('Application settings updated successfully'),
            'url'  => route('admin.clear_cache')
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => false,
            'type' => 'error',
            'message' => translate('Something went wrong')
        ]);
    }
}

    public function payment_gateway(){
        valid_session('settings','payment_gateway');
        return view('backend.settings.payment_gateway_list');
    }

    public function payment_gateway_list(Request $request){
        $totalData = $totalFiltered = 0; $datalist = [];
        $columns = $request['columns'];
        $data = array();
        $like = '';
        $order = '';
        $order_dir = '';
        $limit = $request['length'];
        $start = $request['start'];
        $search = $request['search'];
        if(isset($search['value']) && $search['value']!=''){
            $like = $search['value'];
        }
        $order_array= $request['order'];
        if(isset($order_array[0]['column']) && $order_array[0]['column']!=0){
            $col_id = $order_array[0]['column'];
            $order = $columns[$col_id]['data'];
            $order_dir = $order_array[0]['dir'];
        }
        try {
            DB::beginTransaction();
                $totalData = Payment_gateway::count();
                $totalFiltered = Payment_gateway::where('name','LIKE','%'.$like.'%')
                                ->count();
                $datalist = Payment_gateway::where('name','LIKE','%'.$like.'%')
                                ->skip($start)
                                ->take($limit)
                                ->orderBy($order,$order_dir)
                                ->get();
            DB::commit();
        } catch(\Exception $exp) {
            DB::rollBack();
        }
        if ( isset($datalist) && ! empty($datalist)) {
            foreach ($datalist as $list) {
                $edit = '';
                if(valid_session('settings','payment_gateway',false)){
                    $edit = '<a href="'.route('admin.settings.edit_payment_gateway',['id'=>encode_string($list->id)]).'" class="btn ripple btn-primary btn-sm mt-1 mb-1 text-sm text-white popup-page" data-placement="top" data-toggle="tooltip" title="'.translate('Edit').'"> <i class="fa fa-edit"></i> </a>';
                }
                $details = '<a href="'.route('admin.settings.payment_gateway_details',['id'=>encode_string($list->id)]).'" class="btn ripple btn-secondary btn-sm mt-1 mb-1 text-sm text-white popup-page" data-placement="top" data-toggle="tooltip" title="'.translate('Details').'"> <i class="fa fa-eye"></i> </a>';
                $status = $list->is_active=='1' ? '<span class="badge bg-success cursor-pointer change-status" data-action="change_status" data-id="'.encode_string($list->id).'" data-url="'.route('admin.settings.change-payment-status').'">'.translate('Active').'</span>' : '<span class="badge bg-danger cursor-pointer change-status" data-action="change_status" data-id="'.encode_string($list->id).'" data-url="'.route('admin.settings.change-payment-status').'">'.translate('Inactive').'</span>';
                $image = uploads_url($list->image,uploads_url('default.png'));

                $nestedData = array();
                $nestedData['id']           = $list->id;
                $nestedData['image']        = '<a data-fancybox="image" data-src="'.$image.'" data-caption="'.$list->name.'"><img alt="'.$list->name.'" class="radius cursor-pointer image-delay" src="'.uploads_url('loader.gif').'" data-src="'.$image.'" style="width:48px;height:48px;"></a>';      
                $nestedData['name']         = $list->name;
                $nestedData['description']  = $list->description;
                $nestedData['created_at']   = $list->created_at;
                $nestedData['status']       = $status;
                $nestedData['actions']      = '<div class="btn-group" role="group"">'.$edit.$details.'</div>';
                $data[]                     = $nestedData;
            }
        }
        return response()->json([
            "draw"            => $request['draw'],
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data,
        ]);
    }

    public function update_payment_gateway(Request $request){
        $updated = array();
        $updated['type'] = 'admin';
        $updated['id'] = session('id');
        $status = false;
        $type = 'error';
        $title = translate('Payment Gateway');
        $msg = translate('Invalid Request');

        $validation['name'] = 'required';
        $validation['description'] = 'required';
        $validation['is_active'] = 'required';
        $p_id = decode_string($request['id']);
        if(isset($p_id) && $p_id!=1){
            $validation['payment_gateway'] = 'required';
        }
        $validator = Validator::make($request->all(), $validation);
        $attrNames = [
            'image' => translate('Image'),
            'name' => translate('Name'),
            'description' => translate('Description'),
            'is_active' => translate('Status')
        ];
        $validator->setAttributeNames($attrNames); 
        if ($validator->fails()) {
            return response()->json([
                'status' => $status,
                'type' => $type,
                'title'  => $title,
                'message'  => $validator->errors()->all()
            ]);
        }
        
        try {
            DB::beginTransaction();
            if($request['id']!= ''){ 
                $id = decode_string($request['id']);
                $up_data = array();
                $up_data['image'] = str_replace([getBaseURL().'public/uploads/'],[''], $request['image']);
                $up_data['name'] = $request['name'];
                $up_data['description'] = $request['description'];
                $up_data['is_active'] = $request['is_active'];
                if($id!=1){
                    $up_data['details'] = json_encode($request['payment_gateway']);
                }
                $up_data['created_by'] = json_encode($updated);
                $up_data['updated_by'] = json_encode($updated);
                $pay_id = Payment_gateway::where('id','=',$id)
                        ->update($up_data);
                if(empty($pay_id)){
                    DB::rollBack();
                    return response()->json([
                        'status' => $status,
                        'type' => $type,
                        'title'  => $title,
                        'message'  => translate('Something Went Wrong')
                    ]);
                }else{
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'type' => 'success',
                        'title'  => $title,
                        'message'  => translate('Details Updated Successfully')
                    ]);
                }
            }
            
        } catch(\Exception $exp) {
            DB::rollBack();
            return response([
                'status' => false,
                'type' => 'error',
                'title'  => $title,
                'message' => $msg
            ]);
        }
    }

    public function edit_payment_gateway(Request $request,$id){
        if ($request->ajax()) {
            $id = decode_string($id);
            $page_data = array();
            $page_data['page_title'] = 'Update Payment Gateway';
            $page_data['id'] = '';
            $page_data['page_action'] = route('admin.settings.update_payment_gateway');
            if($id!=''){
                $page_data['id'] = encode_string($id);
                $page_data['payment_details'] = Payment_gateway::where('id','=',$id)
                                    ->first();
            }
            return view('backend.settings.popup-payment_gateway',$page_data);
        }else{
            abort(404);
        }
    }
public function Pages()
{
    $pages = Page::select('id', 'name')
                 ->where('is_active', '1')
                 ->get();
    if ($pages->isEmpty()) {
        return view('backend.settings.application', [
            'page' => $pages,
            'selectedPageId1' => null,
            'selectedPageId2' => null,
            'selectedPageId3' => null,
            'selectedPageId4' => null
        ]);
    }
    $randomPages = $pages->random(min(4, $pages->count()))->pluck('id')->all();
    return view('backend.settings.application', [
        'page' => $pages,
        'selectedPageId1' => $randomPages[0] ?? null,
        'selectedPageId2' => $randomPages[1] ?? null,
        'selectedPageId3' => $randomPages[2] ?? null,
        'selectedPageId4' => $randomPages[3] ?? null,
    ]);
}
    public function change_payment_status(Request $request){
        if ($request->ajax()) {
            $status = false;
            $type = 'error';
            $title = translate('Update Payment Gateway');
            $msg = translate('Invalid Request');
            if(!valid_session('settings','payment_gateway',false)){
                return response()->json([
                    'status' => $status,
                    'type' => $type,
                    'title'  => $title,
                    'message'  => $msg
                ]);
            }
            $id = session('id');
            $updated = array();
            $updated['type'] = 'admin';
            $updated['id'] = $id;
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'action' => 'required'
            ]);
            $attrNames = [
                'id' => translate('id')
            ];
            $validator->setAttributeNames($attrNames); 
            if ($validator->fails()) {
                return response()->json([
                    'status' => $status,
                    'type' => $type,
                    'title'  => $title,
                    'message'  => $validator->errors()->all()
                ]);
            }
            try {
                DB::beginTransaction();
                if($request['id']!= ''){    
                    $id = decode_string($request['id']);   
                    $role = Payment_gateway::where('id','=',$id)->first();           
                    $up_data = array();
                    $up_data['is_active'] = '1';
                    if($role->is_active=='1'){
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = json_encode($updated);
                    $p_id = Payment_gateway::where('id','=',$id)->update($up_data);
                    if(empty($p_id)){
                        DB::rollBack();
                        return response()->json([
                            'status' => $status,
                            'type' => $type,
                            'title'  => $title,
                            'message'  => translate('Something Went Wrong')
                        ]);
                    }else{
                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'type' => 'success',
                            'title'  => $title,
                            'reload'=> true,
                            'message'  => translate('Status Update Successfully')
                        ]);
                    }
                }
            
            } catch(\Exception $exp) {
                DB::rollBack();
                return response([
                    'status' => false,
                    'type' => 'error',
                    'title'  => $title,
                    'message' => $msg
                    // 'message' => $exp->getMessage()
                ]);
            }
        }else{
            abort(404);
        }
    }
    public function payment_gateway_details(Request $request, $id){
        $id = decode_string($id);
        $payment_gateway = array();
        try {
            DB::beginTransaction();
                $payment_gateway = Payment_gateway::where('id','=',$id)
                        ->first();
            DB::commit();
        } catch(\Exception $exp) {
            DB::rollBack();
            //$exp->getMessage();
        }
        if ($request->ajax() && !empty($payment_gateway)) {
            return view('backend.settings.popup-details_payment_gateway',$payment_gateway);
        }else{
            abort(404);
        }
    }


}
