<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\itemsModel;
use App\requestModel;
use Carbon\Carbon;


class orderController extends Controller
{
  public function getOrder(){
    $data = itemsModel::all();
    return response()->json(['data' => $data]);
  }
  public function order(Request $request){
      $rules = array(
        'picture'               => 'required',
        'itemname'              => 'required|alpha',
        'qty'                   => 'required|min:1',
        'comment'               => '',
        'datetofinish'          => 'required|date|date_format: Y-m-d|after: tomorrow',
        'user_userid'           => 'required',
        'category_categoryid'   => 'required',
      );
      $validator = Validator::make($request->all(),$rules);

      if($validator->fails()){
        $message = $validator->messages();
        return  response()->json(['message' => $message->toArray()]);
      }
      else {
        if($request->file('picture')->isValid()){
          $destination = 'upload';
          $extention = $request->file('picture')->getClientOriginalExtension();
          $filename = rand(1111111,9999999).'.'.$extention;
          $request->file('picture')->move($destination, $filename);

          $data = new itemsModel($request->all());
          $data->picture = $destination.'/'.$filename;
          $data->save();
          return response()->json(['message' => "done"]);
        }
        else {
          return response()->json(['message' => "error"]);
        }
      }
  }
  public function requestItem(Request $request, $userid, $itemid){
    $rules = array(
      'price'            => 'required',
      'date_started'     => 'required|date_format: Y-m-d',
      'category'         => 'required'
    );
    $validator = Validator::make($request->all(),$rules);

    if($validator->fails()){
      $message = $validator->messages();
      return  response()->json(['message' => $message->toArray()]);
    }
    else {
      $data = new requestModel($request->all());
      $data->userid = $userid;
      $data->itemid = $itemid;
      $data->save();
      return response()->json(['message' => $data]);
    }
  }
  public function selectBid($id){
    $data =requestModel::find($id);
    $data->status = 1;
    $data->update();
    return response()->json(['data' => $data]);
  }
  public function getRequest($itemid){
    $data = requestModel::where('itemid', $itemid)->where('status', '1')->get();
    if(empty($data[0])){
      $data = requestModel::where('itemid', $itemid)->get();
    }
    return response()->json(['data' => $data]);
  }

  public function statusBar($id, Request $request){
    $data = requestModel::find($id);
    $rules = array('progressbar' => 'required|numeric');
    $validator = Validator::make($request->all(),$rules);

    if($validator->fails()){
      $message = $validator->messages();
      return  response()->json(['message' => $message->toArray()]);
    }
    else {
      $data = requestModel::find($id);
      $data->update($request->all());
      return response()->json(['message' => $data]);
    }
  }
  public function editOrder(Request $request, $id){
    $rules = array(
      'qty'                   => 'required|min:1',
      'comment'               => '',
      'datetofinish'          => 'required|date|date_format: Y-m-d|after: tomorrow',
    );
    $validator = Validator::make($request->all(),$rules);

    if($validator->fails()){
      $message = $validator->messages();
      return  response()->json(['message' => $message->toArray()]);
    }
    else {

        $data = itemsModel::find($id);
        $data->update($request->all());
        return response()->json(['message' => $data]);
    }
  }
  public function history($field,$fieldid){
      $data = requestModel::where($field, $fieldid)->get()->take(5);
      return response()->json(['data' => $data]);
  }
  public function deleteOrder($id){
    $data = itemsModel::find($id);
    $data->delete();

    return response()->json(['message' => 'Data Deleted']);
  }
  public function deleteRequest($id){
    $data = requestModel::find($id);
    $data->delete();

    return response()->json(['message' => 'Data Deleted']);
  }
}
