<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewOrderRequest;
use App\Models\Model;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{

    public function getOrder($id)
    {
        $order = Order::findOrFail($id);
        $user = $order->user;
        $model = $order->model;

        return view('order.edit-order')->with(['order' => $order, 'user' => $user, 'model' => $model]);
    }

    public function postNewOrder(NewOrderRequest $request)
    {
        $model = Model::find($request->get('model-id'));
        $order = $model->order;
        if(is_null($order))
        {
            $order = new Order();
            $order->user_id = $model->user_id;
            $order->model_id = $model->id;
            $order->quantity = 1;
            $order->sub_total = $model->price;
            $order->shipping_costs = "gratuit";
            $order->total = $model->price;
            $order->state = "pending";

            $order->save();
        }
        return redirect('/order/'.$order->id);

    }
}
