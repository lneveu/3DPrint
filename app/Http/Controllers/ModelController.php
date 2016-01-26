<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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
                   $model->scale = 1;

                   $model->save();

                   return redirect('/edit-model/'.$model->id);

               // Invalid model
               case '2' :
                   // Delete model
                   unlink($path.$fileName);
                   return redirect()->back()->with(['error' => 'Votre modèle n\'est pas valide. Veuiller le corriger et le transférer à nouveau.']);

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
        $dateUpdate["day"] = $model->updated_at->day;
        $dateUpdate["month"] = $this->monthToString($model->updated_at->month);
        $dateUpdate["year"] = $model->updated_at->year;

        return view('models.edit-model')->with(array('model' =>  $model, 'dateUpdate' => $dateUpdate));
    }

    private function monthToString($month)
    {
        switch($month)
        {
            case 1 : return "Janvier";
            case 2 : return "Février";
            case 3 : return "Mars";
            case 4 : return "Avril";
            case 5 : return "Mai";
            case 6 : return "Juin";
            case 7 : return "Juillet";
            case 8 : return "Août";
            case 9 : return "Septembre";
            case 10 : return "Octobre";
            case 11 : return "Novembre";
            case 12 : return "Décembre";

        }
    }

    // Return the file given the model id
    public function getFile($id)
    {
        $model = Model::findOrFail($id);
        if($model->user_id !== \Auth::user()->id) abort(404);

        return response()->download($model->file);

    }

}
