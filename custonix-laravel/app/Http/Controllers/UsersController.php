<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\usersModel;
use Auth;

class UsersController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = usersModel::where('usertype', '!=', 'a')->get();
        return  response()->json(['user' => $user->toArray()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = usersModel::find($id);
        return response()->json(['user' => $user->toArray()]);
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
        'username'        => 'required|min:5',
        'password'        => 'required|digits_between:8,15',
        'email'           => 'required|email',
        'picture'         => 'required',
        'usertype'        => '',
        'firstname'       => 'required',
        'middlename'      => 'required|alpha',
        'lastname'        => 'required|alpha',
        'birthday'        => 'required|date|after:90 years ago|before:18 years ago|date_format:Y-m-d',
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

          $data =usersModel::find($id);
          $data->profilepicture = $destination.'/'.$filename;
          $data->update($request->all());
          return response()->json(['user' => $data]);
        }
        else {
          return response()->json(['message' => "error"]);
        }

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
      $data = usersModel::find($id);
    	$data->delete();
    	return response()->json(['message' => "Data Deleted"]);
    }
}
