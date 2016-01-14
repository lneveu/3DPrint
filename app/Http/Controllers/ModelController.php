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

    }

}