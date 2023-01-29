<?php

namespace App\Http\Middleware;

use App\Models\onePassesModel;
use Closure;
use Illuminate\Http\Request;

class OnePass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $onePassExist = onePassesModel::where('user_id', $user->id)->first();
        if (!$onePassExist) 
            return $next($request);
        return redirect()->route('onePass_change');
        
    }
}
