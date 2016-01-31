<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Model;
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
        if($request->has('civility')) $user->civility = $request->get('civility');
        if($request->has('name')) $user->name = $request->get('name');
        if($request->has('firstname')) $user->firstname = $request->get('firstname');
        if($request->has('email')) $user->email = $request->get('email');
        if($request->has('phone')) $user->phone = $request->get('phone');
        if($request->has('address')) $user->address = $request->get('address');
        if($request->has('address_cpl')) $user->address_cpl = $request->get('address_cpl');
        if($request->has('cp')) $user->cp = $request->get('cp');
        if($request->has('city')) $user->city = $request->get('city');

        $user->save();

        return redirect('/account')->with(['ok' => 'Modifications enregistrées']);
    }

    public function getPasswordChange()
    {
        return view('user.change-password');
    }

    public function postPasswordChange(PasswordChangeRequest $request)
    {
        $user = \Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();
        return redirect('/account')->with(['ok' => 'Votre mot de passe a bien été changé']);
    }

}
