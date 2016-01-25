<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Model;

class ModelController extends Controller
{

    public function getUploadModel()
    {
        return view('models.upload-model');
    }

    public function postUploadModel(\App\Http\Requests\UploadModelRequest $request)
    {
        // Retrieve file
        $file = $request->file('file');
        $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
        $originalName = $fileName;
        $extension = $request->file('file')->getClientOriginalExtension();
        $fileName .= ".".$extension;

        $id = \Auth::user()->id;
        $path = storage_path().'/models/'.$id.'/';
        if(!is_dir($path)) mkdir($path);

        // Rename if file exists
        $i = 1;
        while(file_exists($path.$fileName))
        {
            $actual_name = $originalName.$i;
            $fileName = $actual_name.".".$extension;
            $i++;
        }

        // Save file
        $request->file('file')->move($path, $fileName);


        // Validate file through the validator local server
        $data = array("file" => $path.$fileName);
        $data_string = json_encode($data);

        $ch = curl_init('http://localhost:8080/check/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
        $result = json_decode($result);

       if($result !== null)
       {
           switch($result->code)
           {
               // Valid model
               case '0':
                   $user = \Auth::user();
                   $model = new Model();
                   $model->user_id = $user->id;
                   $model->file = $path.$fileName;
                   $model->title = $fileName;

                   $model->save();

                   return redirect('/edit-model/'.$model->id)->with(['ok' => 'Votre modèle à bien été validé']);

               // Invalid model
               case '2' :
                   // Delete model
                   unlink($path.$fileName);
                   return redirect()->back()->with(['error' => 'Votre modèle n\'est pas valide, il contient des arrêtes non manifolds. Veuiller le corriger et le transférer à nouveau.']);

               // Bad request
               case '-1' :
                   // Delete model
                   unlink($path.$fileName);
                   return redirect()->back()->with(['error' => 'Erreur interne, veuillez contacter un administrateur.[Error -1 : bad request]']);

               // File does not exist
               case '1' :
                   return redirect()->back()->with(['error' => 'Erreur interne, veuillez contacter un administrateur.[Error 1 : file does not exist]']);

               default :
                   return redirect()->back()->with(['error' => 'Erreur interne, veuillez contacter un administrateur.']);
           }
       }

        // No result
        // Delete model
        unlink($path.$fileName);
        return redirect()->back()->with(['error' => 'Erreur interne, veuillez contacter un administrateur.']);

    }

    public function getEditModel($id)
    {
        $model = Model::findOrFail($id);
        return view('models.edit-model')->with(array('model' =>  $model));
    }

}
