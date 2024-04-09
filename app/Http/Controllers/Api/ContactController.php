<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactNotification;
use App\Models\Contact;
use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
   public function index(){
     try{
        $user=Contact::all();
        return response()->json([
         'status'=>true,
         'message'=>'Contact List',
         'data'=>$user
     
        ],200);
        }
     
     catch(\Exception $e){
        return response()->json([
            'status'=>false,
            'message'=>$e->getMessage()
        ],500);
     }

    
}
function store(Request $request){
    try{
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            "subject"=>"required",
        ]);
       if($validator->fails()){
        return response()->json([
            'status'=>false,
            'message'=>$validator->errors()->first(),
            'errors'=>$validator->messages(),
            
        ],400);
       }
        $user=Contact::create($request->all());
        Mail::to(['adhikarishishir50@gmail.com'])->send(new ContactNotification($user));
        return response()->json([
         'status'=>true,
         'message'=>'Mail Send Successfully', 
         'data'=>$user
     
        ],200);
        }
     
     catch(\Exception $e){
        return response()->json([
            'status'=>false,
            'message'=>$e->getMessage()
        ],500);
     }
    }


}