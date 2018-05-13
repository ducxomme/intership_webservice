<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class phong_tro extends Model
{
    protected $table = 'user';

    public function login(Request $request)
    {
        
        // validate
        if ($request->username == null || $request->password == null) {
            return response()->json([
                    'code'      => 410,
                    'message'   => 'username and password is required',
                    'data'=>null
                ], 
                500
            );
        }

    // CALL PROCEDURE
        $kq= DB::select("CALL duc(123)");
        print_r($kq);
        die;

       $kq=DB::table($table)->where('username','=',$request->username)->where('password','=',$request->password)->count();
       if($kq>0)
       {
            $info=DB::table($table)->where('username','=',$request->username)->where('password','=',$request->password)->get();
             return response()->json(['code'=>200,'message'=>'OK','data'=> $info], 200);
       }
       else
       {
         return response()->json(['code'=>401, 'message'=>'invalid username or password', 'data'=>null], 200);
       }
            
    }
}
