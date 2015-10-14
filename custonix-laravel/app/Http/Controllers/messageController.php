<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class messageController extends Controller
{
  public function createMessage(Request $request, $id){
    $rules = array(
      'subject'        => 'required',
      'contain'        => 'required'
    );

    $validator = Validator::make($request->all(),$rules);

    if($validator->fails()){
      $message = $validator->messages();
      return  response()->json(['message' => $message->toArray()]);
    }
    else {
      $data = new messageModel($request->all());
      $data->item_itemid = $id;
      $data->user_userid = Auth::id();
      return  response()->json(['data' => $request->all()]);
    }
  }
  public function getMessage($id){
    $data = messageModel::where('item_itemid', $id)->get();
    return response()->json(['data' => $data]);
  }
  public function deleteMessage($id){
    $data = messageModel::find($id);
    $data->delete();
    return response()->json(['message' => "Data Deleted"]);
  }
}
