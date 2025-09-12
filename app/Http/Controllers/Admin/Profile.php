<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Profile extends Controller
{
    public function basic(Request $request){
        $id = $request->session()->get('id');
        $page_data = array();
        $page_data['page_action'] = route('admin.profile.edit_profile');
        if($id!=''){
            $page_data['user'] = User::where('id','=',$id)
                                ->first();
        }
        return view('backend.profile.basic',$page_data);
    }
    public function edit_profile(Request $request){
        $updated = array();
        $updated['type'] = 'admin';
        $updated['id'] = session('id');
        $status = false;
        $type = 'error';
        $title = translate('role');
        $msg = translate('Invalid Request');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email_id' => 'required',
            'mobile_no' => 'required'
        ]);
        $attrNames = [
            'name' => translate('name'),
            'username' => translate('username'),
            'mobile_no' => translate('mobile'),
            'email_id' => translate('email')
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
            if(session()->has('id')){ 
                $id = $request->session()->get('id');
                $up_data = array();
                $up_data['name'] = $request['name'];
                $up_data['email_id'] = $request['email_id'];
                $up_data['created_by'] = json_encode($updated);
                $up_data['updated_by'] = json_encode($updated);
                $user = User::where('id','=',$id)
                        ->update($up_data);
                if(empty($user)){
                    DB::rollBack();
                    return response()->json([
                        'status' => $status,
                        'type' => $type,
                        'title'  => $title,
                        'message'  => translate('something_went_wrong')
                    ]);
                }else{
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'type' => 'success',
                        'title'  => $title,
                        'message'  => translate('details_updated_successfully')
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
}