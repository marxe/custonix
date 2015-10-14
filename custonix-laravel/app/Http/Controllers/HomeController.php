<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\usersModel;

class HomeController extends Controller
{
  /**
  *Do Login Authentication
  *
  *@param  \Illuminate\Http\Request  $request
  *@return Auth
  */
  public function doLogin(Request $request){
    $rules = array(
      'username' => 'required',
      'password'=> 'required'
    );
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails()){
      $message = $validator->messages();
      return  response()->json(['message' => $message->toArray()]);
    }
    else {
      $data = usersModel::where('username', $request->input('username'))->where('password', $request->input('password'))->where('status', 'a')->first();
      Auth::login($data);
        return  response()->json(['user' => Auth::user()]);
    }
  }
  public function doLogout(){
    Auth::logout();
    return  response()->json(['user' => Auth::id()]);
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
        'username'        => 'required|min:5|unique:user',
        'password'        => 'required|digits_between:8,15',
        'confirmation'    => 'required|same:password',
        'email'           => 'required|email|unique:user',
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

          $data = new usersModel($request->all());
          $data->save();
        return  response()->json(['data' => $request->all()]);
      }
  }

  public function notReg(){
    return response()->json(['message' => 'not Login']);
  }
  public function getUser(){
    return response()->json(['message' => Auth::user()]);
  }
}
