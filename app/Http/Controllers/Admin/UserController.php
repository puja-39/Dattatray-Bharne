<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\user;
use Carbon\Carbon;

class UserController extends Controller
{
    public function list(){
        return view('backend.user.list');
    }

    public function add(){
        $roles = Role::all()->whereNotIn('id', [1, 3]);

        $page_data = array();
        $page_data['page_title']    = 'Add New User';
        $page_data['page_action']   = route('admin.user.add_user');

        return view('backend.user.add-edit',$page_data, compact('roles'));
    }

    public function new_user(Request $request){

        // dd($request->all());
        $profileImage = null;
        if ($request->hasFile('user_profile')) {
            $file = $request->file('user_profile');
            $profileImage = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $profileImage);
        }

        $updated = array();
        $updated['type'] = 'admin';
        $updated['id'] = session('id');
        $status = false;
        $type = 'error';
        $title = translate('User');
        $msg = translate('Invalid Request');

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:admin,username',
            'email' => 'required|email|unique:admin,email_id',
            'name' => 'required',
            'role' => 'required',
            'mobile_no' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'is_active' => 'required',
        ]);
        $attrNames = [
            'username' => translate('username'),
            'email' => translate('email'),
            'name' => translate('name'),
            'role' => translate('role'),
            'mobile_no' => translate('mobile_no'),
            'is_active' => translate('is_active'),
            
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
            $up_data = array();
            $up_data['username'] = $request['username'];
            $up_data['email_id'] = $request['email'];
            $up_data['name'] = $request['name'];
            $up_data['role_id'] = $request['role'];
            $up_data['mobile_no'] = $request['mobile_no'];
            $up_data['profile_image'] = $profileImage;
            $up_data['is_active'] = $request['is_active'];
            $up_data['created_by'] = json_encode($updated);
            $up_data['updated_by'] = json_encode($updated);
            $user =user::insert($up_data);
            if (empty($user)) {
                DB::rollBack();
                return response()->json([
                    'status' => $status,
                    'type' => $type,
                    'title'  => $title,
                    'message'  => translate('Something Went Wrong')
                ]);
            } else {
                DB::commit();
                return response()->json([
                    'status' => true,
                    'type' => 'success',
                    'title'  => $title,
                    'message'  => translate('Details Added Successfully')
                ]);
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return response([
                'status' => false,
                'type' => 'error',
                'title'  => $title,
                // 'message' => $msg,
                'message' => $exp->getMessage()

            ]);
        }
    }

    public function ajax_list(Request $request)
    {

        // dd($request->all());
        $totalData = $totalFiltered = 0;
        $datalist = [];
        $columns = $request['columns'];
        $data = array();
        $like = '';
        $order = '';
        $order_dir = '';
        $limit = $request['length'];
        $start = $request['start'];
        $search = $request['search'];
        if (isset($search['value']) && $search['value'] != '') {
            $like = $search['value'];
        }
        $order_array = $request['order'];
        if (isset($order_array[0]['column']) && $order_array[0]['column'] != 0) {
            $col_id = $order_array[0]['column'];
            $order = $columns[$col_id]['data'];
            $order_dir = $order_array[0]['dir'];
        }
        try {
            
            $permissionQuery =user::where('name', 'LIKE', '%' . $like . '%')
		        ->whereRaw('JSON_EXTRACT(created_by, "$.id") = ?', session('id'));

            DB::beginTransaction();
            $totalData = $permissionQuery->count();
            $totalFiltered = $permissionQuery
                ->count();
            $datalist = $permissionQuery
                ->where('name', 'LIKE', '%' . $like . '%')
                ->skip($start)
                ->take($limit)
                ->orderBy($order, $order_dir)
                ->get();
          
            DB::commit();
        } catch (\Exception $exp) {
            DB::rollBack();
        }
        if (isset($datalist) && ! empty($datalist)) {
            foreach ($datalist as $list) {
                $edit = '';
                $setpassword = '';
                if (valid_session('user', 'edit', false)) {
                    $edit = '<a href="' . route('admin.user.edit', ['id' => encode_string($list->id)]) . '" class="btn ripple btn-primary btn-sm mt-1 mb-1 text-sm text-white popup-page" data-placement="top" data-toggle="tooltip" title="' . translate('Edit') . '"> <i class="fa fa-edit"></i> </a>';
                }
                $details = '<a href="' . route('admin.user.quick_details', ['id' => encode_string($list->id)]) . '" class="btn ripple btn-secondary btn-sm mt-1 mb-1 text-sm text-white popup-page" data-placement="top" data-toggle="tooltip" title="' . translate('Details') . '"> <i class="fa fa-eye"></i> </a>';
                
                $setpassword = '<a href="' . route('admin.user.passsword', ['id' => encode_string($list->id)]) . '" class="btn btn-primary btn-sm text-sm text-white mb-1 mt-1 ripple popup-page" data-placement="top" data-toggle="tooltip" title="' . translate('Password') . '"> <i class="fa fa-key"></i> </a>';
            
                $role = Role::where('id', '=', $list->role_id)->first();
                
                $list->role_name = $role ? $role->name : translate('-');

                $status = $list->is_active == '1' ? '<span class="badge bg-success cursor-pointer change-status" data-action="change_status" data-id="' . encode_string($list->id) . '" data-url="' . route('admin.user.change-status') . '">' . translate('Active') . '</span>' : '<span class="badge bg-danger cursor-pointer change-status" data-action="change_status" data-id="' . encode_string($list->id) . '" data-url="' . route('admin.user.change-status') . '">' . translate('Inactive') . '</span>';
            
                $profileImage = $list->profile_image ? '<img src="' . asset('public/uploads/profile/' . $list->profile_image) . '" class="rounded-circle" width="50" height="50" alt="">' : '<img src="' . asset('public/uploads/profile/default.png') . '" class="rounded-circle" width="50" height="50" alt="">';
                $nestedData = array();
                $nestedData['id']           = $list->id;
                $nestedData['profile_image'] = $profileImage;
                $nestedData['name']         = $list->name;
                $nestedData['email_id']      = $list->email_id;
                $nestedData['mobile_no']     = $list->mobile_no;
                $nestedData['Role']     = $list->role_name;
                $nestedData['created_at']   = Carbon::parse($list->created_at)->format('M d, Y');
                $nestedData['status']       = $status;
                $nestedData['actions']      = '<div class="btn-group" role="group"">' . $edit . $details . $setpassword . '</div>';
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


    public function quick_details(Request $request, $id)
    {
        $id = decode_string($id);
        $user = array();
        try {
            DB::beginTransaction();
            $user =user::where('id', '=', $id)
                ->first();
            DB::commit();
        } catch (\Exception $exp) {
            DB::rollBack();
            //$exp->getMessage();
        }
        if ($request->ajax() && !empty($user)) {
            return view('backend.user.quick_details', compact('user'));
        } else {
            abort(404);
        }
    }


    public function edit(Request $request, $id)
    {
        // $roles = Role::all();  
        $roles = Role::all()->whereNotIn('id', [1, 3]);
        if ($request->ajax()) {
            $id = decode_string($id);
            $page_data = array();
            $page_data['page_title'] = 'Update User';
            $page_data['id'] = '';
            $page_data['page_action'] = route('admin.user.edit_user');
            if ($id != '') {
                $page_data['id'] = encode_string($id);
                $page_data['user'] =user::where('id', '=', $id)->first();
            }
            return view('backend.user.add-edit', $page_data, compact('roles'));
        } else {
            abort(404);
        }
    }

    public function edit_user(Request $request){
        // dd($request->all());

        $profileImage = null;
        if ($request->hasFile('user_profile')) {
            $file = $request->file('user_profile');
            $profileImage = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $profileImage);
        }

        $updated = array();
        $updated['type'] = 'admin';
        $updated['id'] = session('id');
        $status = false;
        $type = 'error';
        $title = translate('User');
        $msg = translate('Invalid Request');

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:admin,username,' . (isset($request['id']) ? decode_string($request['id']) : 'NULL') . ',id',
            'email' => 'required|email|unique:admin,email_id,' . (isset($request['id']) ? decode_string($request['id']) : 'NULL') . ',id',
            'name' => 'required',
            'role' => 'required',
            'mobile_no' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'is_active' => 'required',
        ]);
        $attrNames = [
            'username' => translate('username'),
            'email' => translate('email'),
            'name' => translate('name'),
            'role' => translate('role'),
            'mobile_no' => translate('mobile_no'),
            'is_active' => translate('is_active'),
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
            if ($request['id'] != '') {
                $id = decode_string($request['id']);
                // dd($id);
                $up_data = array();

                $up_data['username'] = $request['username'];
                $up_data['email_id'] = $request['email'];
                $up_data['name'] = $request['name'];
                $up_data['role_id'] = $request['role'];
                $up_data['mobile_no'] = $request['mobile_no'];
                if ($profileImage) {
                    $up_data['profile_image'] = $profileImage;
                }
                $up_data['is_active'] = $request['is_active'];
                $up_data['created_by'] = json_encode($updated);
                $up_data['updated_by'] = json_encode($updated);

                $user =user::where('id', '=', $id)
                    ->update($up_data);
                if (empty($user)) {
                    DB::rollBack();
                    return response()->json([
                        'status' => $status,
                        'type' => $type,
                        'title'  => $title,
                        'message'  => translate('Something Went Wrong')
                    ]);
                } else {
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'type' => 'success',
                        'title'  => $title,
                        'message'  => translate('Details Updated Successfully')
                    ]);
                }
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return response([
                'status' => false,
                'type' => 'error',
                'title'  => $title,
                'message' => $msg
                // 'message' => $exp->getMessage()
            ]);
        }
        
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $status = false;
            $type = 'error';
            $title = translate('Update User');
            $msg = translate('Invalid Request');
            if (!valid_session('user', 'edit', false)) {
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
                if ($request['id'] != '') {
                    $id = decode_string($request['id']);
                    $role =user::where('id', '=', $id)->first();
                    $up_data = array();
                    $up_data['is_active'] = '1';
                    if ($role->is_active == '1') {
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = json_encode($updated);
                    $user =user::where('id', '=', $id)->update($up_data);
                    if (empty($user)) {
                        DB::rollBack();
                        return response()->json([
                            'status' => $status,
                            'type' => $type,
                            'title'  => $title,
                            'message'  => translate('Something Went Wrong')
                        ]);
                    } else {
                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'type' => 'success',
                            'title'  => $title,
                            'reload' => true,
                            'message'  => translate('Status Update Successfully')
                        ]);
                    }
                }
            } catch (\Exception $exp) {
                DB::rollBack();
                return response([
                    'status' => false,
                    'type' => 'error',
                    'title'  => $title,
                    'message' => $msg
                    // 'message' => $exp->getMessage()
                ]);
            }
        } else {
            abort(404);
        }
    }

    public function password(Request $request, $id){
        // dd($id);
        if ($request->ajax()) {
            $id = decode_string($id);
            $page_data = array();
            $page_data['page_title'] = 'Update Password';
            $page_data['id'] = '';
            $page_data['page_action'] = route('admin.user.set-passsword');
            if ($id != '') {
                $page_data['id'] = encode_string($id);
                $page_data['user'] =user::where('id', '=', $id)->first();
            }
            return view('backend.user.password-add-edit', $page_data);
        } else {
            abort(404);
        }
    }

    public function set_password(Request $request){
        // dd($request->all());

        $admin_pass = sha1($request->admin_password);
        // dd($admin_pass);
        $admin_id = session('id');
        // dd($admin_id);
        $user =user::all()->where('id','=',$admin_id)->first();
        // dd($member);
        $adminpass = $user->password;
        // dd($adminpass);

        $updated = array();
        $updated['type'] = 'admin';
        $updated['id'] = session('id');
        $status = false;
        $type = 'error';
        $title = translate('User');
        $msg = translate('Invalid Request');

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirmed_password' => 'required|same:password',
            'admin_password' => 'required',
        ]);
        $attrNames = [
            'password' => translate('password'),
            'confirmed_password' => translate('confirmed_password'),
            'admin_password' => translate('admin_password'),
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

        if($admin_pass != $adminpass){
            // dd('not matched');
            return response()->json([
                'status' => $status,
                'type' => $type,
                'title'  => $title,
                'message'  => 'Admin Password Do not Match'
            ]);
        }

        try {
            DB::beginTransaction();
            if ($request['id'] != '') {
                $id = decode_string($request['id']);
                // dd($id);
                $up_data = array();

                $up_data['password'] = sha1($request['password']);

                $up_data['created_by'] = json_encode($updated);
                $up_data['updated_by'] = json_encode($updated);

                $user =user::where('id', '=', $id)
                    ->update($up_data);
                if (empty($user)) {
                    DB::rollBack();
                    return response()->json([
                        'status' => $status,
                        'type' => $type,
                        'title'  => $title,
                        'message'  => translate('Something Went Wrong')
                    ]);
                } else {
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'type' => 'success',
                        'title'  => $title,
                        'message'  => translate('Password Updated Successfully')
                    ]);
                }
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return response([
                'status' => false,
                'type' => 'error',
                'title'  => $title,
                'message' => $msg
                // 'message' => $exp->getMessage()
            ]);
        }

    }

    public function forgot_password(Request $request, $supervisor_id)
    {
        $page_data = array();

        $decoded = decode_string($supervisor_id);
        if (!$decoded || strpos($decoded, '|') === false) {
            abort(404, 'Invalid or tampered link.');
        }

        list($id, $sentTime) = explode('|', $decoded);

        if (time() - $sentTime > 300) {
            return response('This password reset link has expired. Please request a new one.', 410);
        }

        $page_data['page_title']    = 'Reset Password';
        $page_data['page_action']   = route('web.reset_password');
        $page_data['supervisor_id'] = $id;
        return view('backend.user.forgot-password', $page_data);
    }

    public function reset_password(Request $request)
    {
        $supervisor_id = $request->supervisor_id;

        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);
        $attrNames = [
            'password' => translate('password'),
        ];
        $validator->setAttributeNames($attrNames);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            if (!empty($supervisor_id)) {
                $up_data = array();
                $up_data['password'] = sha1($request['password']);

                $user =user::where('id', '=', $supervisor_id)
                    ->update($up_data);
                if (empty($user)) {
                    DB::rollBack();
                    return redirect()->back()->with('error', translate('Something Went Wrong'));
                } else {
                    DB::commit();
                    return redirect()->back()->with('success', translate('Password Updated Successfully'));
                }
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', translate('Invalid Request'));
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return redirect()->back()->with('error', translate('Invalid Request'));
        }
    }




}
