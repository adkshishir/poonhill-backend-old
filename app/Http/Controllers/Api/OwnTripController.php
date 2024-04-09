<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OwnTripAdmin;
use App\Mail\OwnTripUser;
use App\Models\OwnTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OwnTripController extends Controller
{

    public function index(){
    // check if the user is admin or not 
    if(auth()->user()->role=='admin'){
        $ownTrips=OwnTrip::all();
        if($ownTrips->isEmpty()){
            return response()->json([
                'status' => false,
                'message' => 'No trips found',
                'data' => []
            ],404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Trips found',
            'data' => $ownTrips
        ],200);
    }
    }
    public function sendOwnTripByGuest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|string',
            'description' => 'string',
            'name'=>'string|required',
             'email'=>'email|required',
             'phone'=>'string|required',
              'country'=>'string|required',
               'duration'=>'|required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => []
            ], 400);
        }
        $details=$request->all();
        
        try{
            // dd($ownTrip,env("ADMIN_MAIL"),$request->email);
         
            // dd(env("ADMIN_EMAIL"));
            Mail::to([$request->email])->send(new OwnTripUser($details));
            Mail::to(['adhikarishishir50@gmail.com'])->send(new OwnTripAdmin($details));
            return response()->json([
                "status"=>true,
                'message'=>"Email sent successfully",
                'data'=>[]
            ],200);
        }catch(\Exception $e){
            return response()->json([
                "status"=>false,
                'message'=>$e->getMessage(),
                'data'=>[]
            ],500);
        }
    }
    public function sendOwnTripByUser(Request $request)
    {
       
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255|string',
                'description' => 'string',
                  'country'=>'string|required',
                   'duration'=>'required',
            ]);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ], 400);
            }
            $user=Auth::user();
            $details=$request->all();
            $details['email']=$user->email;
            $details['phone']=$user->phone;
            $details['name']=$user->name;
            Mail::to([$user->email])->send(new OwnTripUser($details));
            Mail::to(['adhikarishishir50@gmail.com'])->send(new OwnTripAdmin($details));
            return response()->json([
                "status"=>true,
                'message'=>"Email sent successfully",
                'data'=>[]
            ],200);
        }catch(\Exception $e){
            return response()->json([
                "status"=>false,
                'message'=>$e->getMessage(),
                'data'=>[]
            ],500);
        }
    }
     
}
