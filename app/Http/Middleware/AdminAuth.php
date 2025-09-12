<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\Role;
use Route;
class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $is_valid_login = false;

        if(session()->has('id') && session()->has('web_auth_key')){
            $id = session('id');
            $web_auth_key = session('web_auth_key');
            $user = User::where('id','=',$id)
                    ->where('web_auth_key','=',$web_auth_key)
                    ->first();
            
            if(!empty($user)){
                $role = Role::where('id','=',$user->role_id)
                        ->where('is_active','=','1')
                        ->first();

                if(!empty($role)){
                    $permissions = array();
                    if($user->role_id!=1){
                        $permissions = json_decode($role->permissions,true);
                    }
                    Config::set('deepinfo.permissions', $permissions);
                    Config::set('deepinfo.role_id', $role->id);
                    Config::set('deepinfo.admin_id', $user->id);
                    $is_valid_login = true;
                }
            }
        }
        $loginRoutes = ['admin.login','admin.forgot_password','admin.reset_password','admin.check_login'];
        $currentRoute = Route::current()->getName();
        if($is_valid_login && in_array($currentRoute, $loginRoutes)){
            return redirect()->route('admin.dashboard');
        }else if(($is_valid_login && !in_array($currentRoute, $loginRoutes)) || (!$is_valid_login && in_array($currentRoute, $loginRoutes))){
            return $next($request);
        }else{
            return redirect()->route('admin.login');
        }
    }
}
