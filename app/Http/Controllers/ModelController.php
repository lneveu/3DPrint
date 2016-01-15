<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ModelController extends Controller
{

    public function getUploadModel()
    {
        return view('upload-model');
    }

    public function postUploadModel(\App\Http\Requests\UploadModelRequest $request)
    {
        // Rename + Save file
        $file = $request->file('file');
        $extension = $request->file('file')->getClientOriginalExtension();
        $fileName = md5($file).'.'.$extension;
        $path = storage_path().'/models/';
        $request->file('file')->move($path, $fileName);

        return redirect()->back()->with(['status' => 'Votre modèle à bien été sauvegardé']);

    }

}