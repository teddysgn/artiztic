<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Carbon\Carbon;
use Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth as Auth;
use App\Models\UserModel;
 
class CheckUserOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()) {
            $expiredAt = now()->addMinutes(2);
            Cache::put('user-is-online-'. Auth::user()->id, true, $expiredAt);
            $userModel = new UserModel();
            $userModel->saveItem(Auth::user(), ['task' => 'update-last-activity']);
        }
 
        return $next($request);
    }
}