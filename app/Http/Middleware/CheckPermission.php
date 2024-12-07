<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use App\Models\RoleHasPermission;
class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        $current_route = \Route::currentRouteName();
        $current_route_split_data = explode('.',$current_route);
        // echo "<pre>"; print_r($current_route_split_data); exit;
        $current_module = $current_route_split_data[0];
        $current_action = $current_route_split_data[1];
        $actions_list = [
            'list'=>[
                'index','getListings'
            ],
            'create'=>[
                'create','store'
            ],
            'edit'=>[
                'edit','update'
            ],
            'delete'=>[
                'destroy','delete'
            ],
            'show'=>[
                'show'
            ],
        ];
        $user_permissions = RoleHasPermission::with('permissions:id,name')->where('role_id',Auth::user()->role)->get()->toArray();

        $has_permission = false;
        foreach ($user_permissions as $permission) {
            $p = $permission['permissions']['name'];
            $split_data = explode('-',$p);
            $module = $split_data[0];
            $action = $split_data[1];

            if($current_module==$module and (isset($actions_list[$action]) and in_array($current_action,$actions_list[$action]))):
                $has_permission = true;
            endif;

        }
        if(!$has_permission):
            abort('401');
        endif;
        return $next($request);
    }
}
