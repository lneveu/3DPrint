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

    public function postEditTitle(Request $request)
    {
        if($request->ajax() && $request->has('id') && $request->has('title'))
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
                $model->title = $request->get('title');
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

}
