<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use App\Models\Group;
use Illuminate\Support\Facades\URL;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_group_id = Auth::user()->group_id;
        $group = Group::find($user_group_id);
        $permission = json_decode($group->permission, 1);
        #
        $controller = getCurrentController();
        $action = getCurrentAction();

        if (!in_array($controller, ['home', 'ajax']) && $action != 'logout') {
            if ($action == 'update') {
                if (!empty(getCurrentParams())) $action = 'edit';
                else $action = 'add';
            }
            if (empty($permission[$controller][$action])) {
                return redirect('/admin/home');
            }
        }

        session_start();
        $_SESSION['user'] = Auth::user()->username;
        if(isset($permission['imageManagement']['index'])){
            $_SESSION['imageManagement'] = $permission['imageManagement']['index'];
        }

        return $next($request);
    }
}
