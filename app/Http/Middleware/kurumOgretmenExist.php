<?php

namespace App\Http\Middleware;

use App\Models\ogretmenKurumModel;
use Closure;
use Illuminate\Http\Request;

class kurumOgretmenExist
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
        $kurumExist = ogretmenKurumModel::where('ogretmen_id', auth()->user()->id)->first();
        if ($kurumExist)
            return $next($request);
        return redirect()->route('ogretmen_dash')->withErrors('Bir kuruma ait değilsiniz');
    }
}
