<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class roomController extends Controller
{
    public function getAllRoom(){
    	$result = DB::table('room')->get();
    	return response()->json(['statuscode' => 200, 'data' => $result], 200);			
    }

    public function getRoomDetail(Request $request){
    	$result = DB::table('room')->where('room_id', '=', $request->room_id)->get();
    	return response()->json(['statuscode' => 200, 'data' => $result], 200);	
    }

    public function addRoom(Request $request){
    	$result = DB::table('room')->insertGetId([
    		'username'		=> $request->username,
    		'ward_id' 		=> $request->ward_id,
    		'area'	 	 	=> $request->area,
    		'price'	  		=> $request->price,
    		'rooms_empty'	=> $request->rooms_empty
    	]);	
    	//DB::table('room')->where('room_id', '=', $result)->get()
    	return response()->json(['statuscode' => 200, 'data' => DB::table('room')->where('room_id', '=', $result)->get()], 200);
    }

    public function updateRoomDetail(Request $request){
    	$old_ward_id = DB::table('room')->select('ward_id')->where('room_id', '=', $request->room_id)->first();
    	$ward_id = $request->ward_id == null ? $old_ward_id->ward_id : $request->ward_id;
    	
		$old_area = DB::table('room')->select('area')->where('room_id', '=', $request->room_id)->first();
    	$area = $request->area == null ? $old_area->area : $request->area;
    	
    	$old_price = DB::table('room')->select('price')->where('room_id', '=', $request->room_id)->first();
    	$price = $request->price == null ? $old_price->price : $request->price;
    	
    	$old_rooms_empty = DB::table('room')->select('rooms_empty')->where('room_id', '=', $request->room_id)->first();
    	$rooms_empty = $request->rooms_empty == null ? $old_rooms_empty->rooms_empty : $request->rooms_empty;
    	
    	$old_public = DB::table('room')->select('public')->where('room_id', '=', $request->room_id)->first();
    	$public = $request->public == null ? $old_public->public : $request->public;

    	$result = DB::table('room')
    				->where('room_id', '=', $request->room_id)
    				->update([
    					'ward_id' 	=> $ward_id,
    					'area'		=> $area,
    					'price'		=> $price,
    					'rooms_empty'=> $rooms_empty,
    					'public' 	=> $public 
    				]);		
    	return response()->json(['statuscode'=>200, 'message' => 'OK', 'data'=>DB::table('room')->where('room_id', '=', $request->room_id)->get()], 200);  
    }

    public function deleteRoom(Request $request){
    	$result = DB::table('room')->where('room_id', '=', $request->room_id)->delete();
    	return response()->json(['statuscode' => 200, 'message' => "Delete Success"], 200);
    }

    public function searchRoomByPrice(Request $request){
    	$result = DB::table('room')->whereBetween('price', [$request->from, $request->to])->get();
    	return response()->json(['statuscode' => 200, 'message' => 'OK', 'data' => $result], 200);
    }

    public function searchRoomByAddress(Request $request){
    	if ($request->district_id == null) {
    		// Tim theo phuong, xa
    		$result = DB::table('room')->where('ward_id', '=', $request->ward_id)->get();
    	}else if ($request->ward_id == null){
    		$result = DB::table('room')
    					->join('ward', 'room.ward_id', '=', 'ward.ward_id')
    					->join('district', 'ward.district_id', '=', 'district.district_id')
    					->where('district.district_id', '=', $request->district_id)
    					->select('room.*')->get();
    	}	
    	return response()->json(['statuscode' => 200, 'message' => 'OK', 'data' => $result], 200);
    }
}
