<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\categoryModel;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $category = categoryModel::all();
      return  response()->json(['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = array(
        'categoryname'          => 'required|unique:category',
        'categorydescription'   => '',
        'imageicon'             => ''
      );

      $validator = Validator::make($request->all(),$rules);

      if($validator->fails()){
        $message = $validator->messages();
        return  response()->json(['message' => $message->toArray()]);
      }
      else {
        $data = new categoryModel($request->all());
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
        $category = categoryModel::find($id);
        return response()->json(['category' => $category]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $rules = array(
        'categoryname'          => 'required|unique:category',
        'categorydescription'   => '',
        'imageicon'             => ''
      );

      $validator = Validator::make($request->all(),$rules);

      if($validator->fails()){
        $message = $validator->messages();
        return  response()->json(['message' => $message->toArray()]);
      }
      else {
        $data = new categoryModel($request->all());
        $data->update($request->all());
        return  response()->json(['data' => $request->all()]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $data = categoryModel::find($id);
      $data->delete();
      return response()->json(['message' => "Data Deleted"]);
    }
}
