<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Model;


class UserOwnModel
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
        $model = Model::findOrFail($request->id);

        if($model->user_id !== \Auth::user()->id) abort(404);

        return $next($request);
    }
}
