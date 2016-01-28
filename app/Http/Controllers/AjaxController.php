<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class AjaxController extends Controller
{

    public function postEditModel(Request $request)
    {
        if($request->ajax() && $request->has('id'))
        {
            $id = $request->get('id');
            $model = Model::findOrFail($id);

            if($model->user_id !== \Auth::user()->id)
            {
                return response()->json([
                    'error' => true,
                    'message' => 'you are not allowed to update this model'
                ], 422);
            }
            else
            {
                if($request->has('title')) $model->title = $request->get('title');
                if($request->has('scale')) $model->scale = $request->get('scale');
                if($request->has('scalemin')) $model->scale_min = $request->get('scalemin');
                if($request->has('scalemax')) $model->scale_max = $request->get('scalemax');
                if($request->has('unit')) $model->unit = $request->get('unit');
                if($request->has('price')) $model->price = $request->get('price');
                if($request->has('length')) $model->length = $request->get('length');
                if($request->has('width')) $model->width = $request->get('width');
                if($request->has('height')) $model->height = $request->get('height');
                if($request->has('volume')) $model->volume = $request->get('volume');
                if($request->has('surface')) $model->surface = $request->get('surface');

                $model->save();

                return response()->json([
                    'success' => true,
                    'message' => 'model updated'
                ], 200);
            }
        }
        return response()->json([
            'error' => true,
            'message' => 'bad request'
        ], 422);
    }

    public function postCheckDimensions(Request $request)
    {
        if($request->ajax() && $request->has('file') && $request->has('opts'))
        {

            $data = array("file" => $request->get('file'), "opts" => array("scale" => $request->get('opts')['scale'], "unit" => $request->get('opts')['unit']));
            $data_string = json_encode($data);

            $ch = curl_init('http://localhost:8080/check-dimensions/');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );

            $result = curl_exec($ch);
            $result = json_decode($result);

            return response()->json([
                'success' => true,
                'data' => $result
            ], 200);
        }
        return response()->json([
            'error' => true,
            'message' => 'bad request'
        ], 422);
    }

}
