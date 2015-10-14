<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\feedbackModel;
use App\usersModel;
use Illuminate\Support\Facades\Validator;

class privilageController extends Controller
{
    public function feedback($id){
        $rules = array(
        'feedbackmessage' => 'required',
        'rating' => 'required',
      );
      $validator = Validator::make($request->all(),$rules);

      if($validator->fails()){
        $message = $validator->messages();
        return  response()->json(['message' => $message->toArray()]);
      }
      else {

          $data = new feedbackModel($request->all());
          $data->user_userid = $id;
          $data->save();
        return  response()->json(['data' => $request->all()]);
      }
    }

    public function setban($id){
      $data =usersModel::find($id);
      $data->status = 'i';
      $data->update();
      return response()->json(['data' => $data]);
    }

    public function getfeedback($id){
      $data = feedbackModel::where('user_userid', $id)->get();
      return response()->json(['data' => $data]);
    }

    public function getban($id){
      $data = usersModel::where('userid', $id)->where('status', 'b')->get();
      return response()->json(['data' => $data]);
    }
    public function releaseban($id){
      $data =usersModel::find($id);
      $data->status = 'a';
      $data->update();
      return response()->json(['data' => $data]);
    }

}
