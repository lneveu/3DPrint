<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Model;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{

    public function getAccount()
    {
        $user = Auth::user();
        return view('user.account')->with(['user' => $user]);
    }

    public function postAccount(UpdateAccountRequest $request)
    {
        $user = Auth::user();
        $user->civility = $request->get('civility');
        $user->name = $request->get('name');
        $user->firstname = $request->get('firstname');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        $user->address_cpl = $request->get('address_cpl');
        $user->cp = $request->get('cp');
        $user->city = $request->get('city');

        $user->save();

        return redirect('/account')->with(['ok' => 'Modifications enregistrées']);
    }

    public function getPasswordChange()
    {
        return view('user.change-password');
    }

    public function postPasswordChange(UpdatePasswordRequest $request)
    {
        $user = \Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();
        return redirect('/account')->with(['ok' => 'Votre mot de passe a bien été changé']);
    }

    public function getModels()
    {
        $user = \Auth::user();
        $models = $user->models;

        return view('user.models')->with(['models' => $models]);
    }

    public function getOrders()
    {
        $user = \Auth::user();
        $orders = Order::where('user_id', '=', $user->id)->paginate(15);

        return view('user.orders')->with(['orders' => $orders]);
    }

}
