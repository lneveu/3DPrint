<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;


class UserOwnOrder
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
        $order = Order::findOrFail($request->id);

        if($order->user_id !== \Auth::user()->id) abort(404);

        return $next($request);
    }
}
