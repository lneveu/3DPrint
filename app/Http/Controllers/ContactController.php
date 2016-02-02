<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ContactController extends Controller
{

    public function getContact()
    {
        return view('others.contact');
    }

    public function postContact(\App\Http\Requests\ContactRequest $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $message = $request->get('message');

        // send message
        
        return redirect('/contact')->with(['ok' => 'Votre message a bien été envoyé.']);
    }
}
