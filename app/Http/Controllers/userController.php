<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use model\phong_tro.php

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // use eloquent 
        // $model= new phong_tro();
       // $phong=$model->login($request);
        
        // validate
        if ($request->username == null || $request->password == null) {
            return response()->json([
                    'statuscode'      => 410,
                    'message'   => 'username and password is required',
                    'data'=>null
                ], 
                200
            );
        }

    // CALL PROCEDURE
        // $kq= DB::select("CALL duc(123)");
        // print_r($kq);
        // die;

       $kq=DB::table("user")->where('username','=',$request->username)->where('password','=',$request->password)->count();
       if($kq>0)
       {
            $info=DB::table("user")->where('username','=',$request->username)->where('password','=',$request->password)->get();
            return response()->json(['statuscode'=>200,'message'=>'OK','data'=> $info], 200);
       }
       else
       {
         return response()->json(['statuscode'=>401, 'message'=>'invalid username or password', 'data'=>null], 200);
       }
            
    }

    public function register(Request $request){
        $kq = DB::table('user')->where('username', '=', $request->username)->count();
        if ($kq > 0) {
            return response()->json(['statuscode'=>401, 'message'=>'username already exist', 'data'=>null]);
        }else{
            $address = $request->address == null ? null : $request->address;
            $email = $request->email == null ? null : $request->email;
            $phone = $request->phone == null ? null : $request->phone;
            
            $user = DB::table('user')->insert([
                'username' => $request->username, 
                'role_id'   => $request->role_id,
                'password' => $request->password,
                'name'     => $request->name,
                'address'  => $address,
                'email'    => $email,
                'phone'    => $phone 
            ]);
            return response()->json(['statuscode'=>200, 'message'=>'OK', 'data'=>DB::table('user')->where('username', '=', $request->username)->get()], 200);
        }
    }

    public function getAllUser() {
        $kq = DB::table('user')->get();
        return response()->json(['statuscode'=>200, 'message'=>'OK', 'data'=>$kq], 200);
    }

    public function updateUser(Request $request){
        $old_pass = DB::table('user')->select('password')->where('username', '=', $request->username)->first();
        $pass = $request->password == null ? $old_pass->password : $request->password;

        $old_name = DB::table('user')->select('name')->where('username', '=', $request->username)->first();
        $name = $request->name == null ? $old_name->name : $request->name;
        
        $old_address = DB::table('user')->select('address')->where('username', '=', $request->username)->first();
        $address = $request->address == null ? $old_address->address : $request->address;
        
        $old_email = DB::table('user')->select('email')->where('username', '=', $request->username)->first();
        $email = $request->email == null ? $old_email->email : $request->email;
        
        $old_phone = DB::table('user')->select('phone')->where('username', '=', $request->username)->first();
        $phone = $request->phone == null ? $old_phone->phone : $request->phone;

        $kq = DB::table('user')
                ->where('username', '=', $request->username)
                ->update([
                    'password' => $pass,
                    'name'     => $name,
                    'address'  => $address,
                    'email'    => $email,
                    'phone'    => $phone
                ]); 
        return response()->json(['statuscode'=>200, 'message'=>'OK', 'data'=>DB::table('user')->where('username', '=', $request->username)->get()], 200);      
    }

    public function getUser(Request $request){
        $kq = DB::table('user')->where('username', '=', $request->username)->get();
        return response()->json(['statuscode' => 200, 'message' => 'OK', 'data' => $kq], 200);       
    }

}
