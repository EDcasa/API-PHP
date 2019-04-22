<?php

namespace App\Http\Controllers;

use App\User;
use http\Env\Response;
use HttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    function index(Request $request){
//        $user = new User();
//        $user-> name = "esmeralda";
//        $user-> email = "esmeralda@tsa.ec";
        //use eloquent for get datas of db
        //activate eloquent in bootstrap
        //for that my function return values may be od content type JSON
        if($request -> isJson()){
            $users= User::all();
            return response()->json([$users],200);
        }
        return response()->json(['error' => 'Unauthorized'],401,[]);
    }

    public function login(Request $request)
    {
        //log::error('Tried of Login'.json_encode($request->all()));
        $validator = Validator::make($request->all(), [
            'use_username' => 'required',
            'use_password' => 'required'
        ]);

        if ($validator->fails())
        {
            //Log::notice('Login successful');
            return response()->json(['error'=>$validator->errors()], 400);
        }

        $username = $request->input("use_username");
        $password = $request->input("use_password");

        //$user = LoginUser::where('use_username', $username)->first();
        //$_passmd5= md5($password);
        if($user && $password){
            //Generacion de un token
            //$user->use_login_token    =  str_random(60);
            //$user->save();
            //User with a new token
 	    $var = "{'user':'test', 'name':'other test'}";
	    return json_encode($var);
        }
        else
        {
            //Log::warning('Warning, User no authorized,Login');
            return response()->json(['error'=>'No Authorized'], 401);
        }
        //Log::error('Error, unauthorized Login');
        return response()->json(['error'=>'Unauthorized'], 406);
    }

    function createdUsers(Request $request){
        if($request -> isJson()){
            $data = $request->json()->all();
            $user = User::create([
                'name'=>$data['name'],
                'username'=>$data['username'],
                'email'=>$data['email'],
                'password'=>Hash::make($data['password']),
                'api_token' => str_random(60)
            ]);
            return response()->json($user,201);
        }
        return response()->json(['error' => 'Unauthorized'],401,[]);
    }

    function getToken(Request $request){
        if($request -> isJson()){
            try{
                $data = $request -> json()->all();
                $user = User::where('username', $data['username'])-> first();
                if ($user && Hash::check($data['password'], $user->password)){
                    return response()->json($user, 200);
                }
                else{
                    return response()->json(['error'=> 'No content'],406);
                }
            }catch(ModelNotFoundException $e){
                return response()->json(['error'=> 'No content'],406);

            }
            #return response()->json($user,201);
        }
        return response()->json(['error' => 'Unauthorized'],401,[]);
    }

    function deleteUser(Request $request){
        if($request->isJson()){
            $data = $request->json()->all();
            $user = User::where('username', $data['username'])->first();
            if($user){
                if($user->delete()){
                    return response()->json($user,200);
                }else{
                    return response()->json(['error'=> 'No content'],406);
                }
            }

        }
        return response()->json(['error' => 'Unauthorized'],401,[]);
    }
}
