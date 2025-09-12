<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Gregwar\Captcha\CaptchaBuilder;
class Login extends Controller
{
    public function login(){
         $captcha = $this->getCaptcha();
        return view('backend.auth.login', compact('captcha'));
    }
public function reloadCaptcha()
{
   
    $builder = new CaptchaBuilder(3);
    $builder->setBackgroundColor(255, 255, 255);
    $builder->setMaxAngle(0);
    $builder->setMaxBehindLines(0);
    $builder->setMaxFrontLines(0);
    $builder->setDistortion(false);
    $number = mt_rand(100, 999);
    $builder->setPhrase((string)$number);
    $builder->build(75, 32);
    session(['phrase' => $number]);
    return $builder->inline();
}

public function getCaptcha()
{
    $builder = new CaptchaBuilder(3);
    $builder->setBackgroundColor(255, 255, 255);
    $builder->setMaxAngle(0);
    $builder->setMaxBehindLines(0);
    $builder->setMaxFrontLines(0);
    $builder->setDistortion(false);
    $number = mt_rand(100, 999);
    $builder->setPhrase((string)$number);
    $builder->build(75, 32);
    session(['phrase' => $number]);
    return $builder->inline();
}
    public function forgot_password(){
        return view('backend.auth.forgot_password');
    }
    public function logout(){
        session()->flush();
        return redirect()->route('admin.login');
    }
    public function login_check(Request $request){
        $status = false;
        $type = 'error';
        $title = translate('Authentication');
        $msg = translate('Invalid Request');

        $validator = Validator::make($request->all(), [ 
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required'
        ]);
         if ($request->captcha != session('phrase')) {
        return response()->json([
            'status' => false,
            'type' => 'error',
            'title'  => $title,
            'message'  => translate('Invalid Captcha')
        ]);
    }

        $attrNames = [
            'username' => translate('Username'),
            'password' => translate('Password')
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
            $user = User::where('username','=',$request['username'])
                    ->where('password','=',sha1($request['password']))
                    ->first();
            if(empty($user)){
                DB::rollBack();
                return response()->json([
                    'status' => $status,
                    'type' => $type,
                    'title'  => $title,
                    'message'  => translate('User Details Not Found')
                ]);
            }else if(isset($user->is_active) && $user->is_active=='0'){
                DB::rollBack();
                return response()->json([
                    'status' => $status,
                    'type' => $type,
                    'title'  => $title,
                    'message'  => translate('User is In Active')
                ]);
            }else{
                $role = Role::where('id','=',$user->role_id)
                        ->where('is_active','=','1')
                        ->first();

                if(empty($role)){
                    DB::rollBack();
                    return response()->json([
                        'status' => true,
                        'type' => 'success',
                        'title'  => $title,
                        'message'  => translate('User Role is Not Active')
                    ]);
                }else{
                    $web_auth_key =md5($user->id.Str::random(16).$user->username);
                    User::where('id', $user->id)
                        ->update(['web_auth_key' => $web_auth_key]);
                    session(['id' => $user->id, 'web_auth_key' => $web_auth_key, 'username' => $user->username ]);

                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'type' => 'success',
                        'title'  => $title,
                        'message'  => translate('User Logged in Successfully'),
                        'url'  => route('admin.dashboard')
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
                //'message' => $exp->getMessage()
            ]);
        }
    }
}
