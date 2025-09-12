<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Contractor;
use App\Models\Role;
use Route;
class UserApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        
        $is_valid_login = false;
        $app_security_key = config('deepinfo.app_security_key');

        $get_security_key = $request['auth_key'] ?? $request['key'] ?? getBearerToken();
        $login_user = null;
        $login_status = false;

        $request_user_id = $request['user_id'] ?? $request['contractor_id'] ?? null;

        if($request_user_id && $get_security_key){
            DB::enableQueryLog();
            $user = Contractor::where('id','=',$request_user_id)
                    ->where('app_auth_key','=',$get_security_key)
                    ->where('role_id','=','4')
                    ->first();
            if(!empty($user)){
                $role = Role::where('id','=',$user->role_id)
                        ->where('is_active','=','1')
                        ->first();

                $tmp_data = array();
                $tmp_data['id'] = $user->id;
                $tmp_data['name'] = $user->name;
                $tmp_data['auth_key'] = $user->app_auth_key;
                $login_user = $tmp_data;
                $login_status = true;
                $is_valid_login = true;
            }
        }

        $exclude_methods = ['api.user.v1.login'];
        $open_methods    =  [];
        $currentRoute = Route::current()->getName();
        if(!in_array($currentRoute, $open_methods)){
            if(in_array($currentRoute, $exclude_methods)){
                if($get_security_key!= $app_security_key){
                    return response()->json([
                        "status" => false,
                        "user_login" => false,
                        'message' => translate('Invalid App Security Key'),
                        "default_image" => uploads_url('default.png'),
                    ]);
                }
                $is_valid_login = true;
            }else{
                if(($get_security_key!= $app_security_key) && !$login_status){
                    return response()->json([
                        "status" => false,
                        "user_login" => false,
                        'message' => translate('Invalid App Security Key'),
                        "default_image" => uploads_url('default.png'),
                    ]);
                }else{
                    $is_valid_login = true;
                }
            }
        }else{
            
            if(($get_security_key!= $app_security_key) && !$login_status){
                return response()->json([
                    "status" => false,
                    "user_login" => false,
                    'message' => translate('Invalid App Security Key'),
                    "default_image" => uploads_url('default.png'),
                ]);
            }else{
                $is_valid_login = true;
            }
        }
        $request->attributes->set('is_valid_login', $is_valid_login);
        if($is_valid_login){
            $response = $next($request);
            $responseData = json_decode($response->getContent(), true);
            if($login_status){
            
                if (!isset($responseData['user'])) {
                    $responseData['user'] = null_handling($login_user); 
                }
                if (!isset($responseData['user_login'])) {
                    $responseData['user_login'] = $login_status;
                }
            }
            return response()->json($responseData);
        }else{
            return response()->json([
                'success' => false,
                'error' => true,
                'login' => false,
                'msg' => translate('Invalid Login Credentials')
            ]);
        }
    }
    
}
