<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\announceModel;

class AnnounceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = array(
        'subject'               => 'required',
        'announce'              => 'required',
        'user_userid'           => 'required'
      );

      $validator = Validator::make($request->all(),$rules);

      if($validator->fails()){
        $message = $validator->messages();
        return  response()->json(['message' => $message->toArray()]);
      }
      else {
        $data = new announceModel($request->all());
        $data->created_at = date('y-m-d H:m:s');
        $data->save();
        return  response()->json(['data' => $request->all()]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $announce = announceModel::where('user_userid','=',$id)->get();
      return response()->json(['announce' => $announce]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $data = announceModel::find($id);
      $data->delete();
      return response()->json(['message' => "Data Deleted"]);
    }
}
