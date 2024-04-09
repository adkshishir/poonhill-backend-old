<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\BookingNotification;
use App\Mail\BookingNotificationAdmin;
use App\Models\Activity;
use App\Models\Booking;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
          
            if (!$user) {
                return response()->json([
                    "status" => false,
                    "message" => "Un Authorized",
                    "data" => []
                ], 401);
            } else if ($user->role != "admin") {
                return response()->json([
                    "status" => false,
                    "message" => "Un Authorized",
                    "data" => []
                ], 401);
            }
            $bookings = Booking::select('user_id', 'activity_id', 'status', 'country', 'arrival_date', 'departure_date')->with ('activity', 'user')->get();
            return response()->json([
                "status" => true,
                "message" => "Data Retrieved",
                "data" => $bookings
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }
    public function oldUserBook(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'activity_id' => 'required',
                'status' => '',
                'country' => '',
                'arrival_date' => 'required',
                'departure_date' => 'required',
                'description' => '',
                'counts' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validator->errors()->first(),
                    "data" => [
                        'errors' => $validator->errors()->all()
                    ]
                ], 400);
            }
            $user=Auth::user();
            $booking = new Booking();
            $booking->activity_id = $request->activity_id;
            $booking->user_id = $user->id;
            $booking->status = "Booked";
            $booking->country = $request->country;
            $booking->arrival_date = $request->arrival_date;
            $booking->departure_date = $request->departure_date;
            $booking->description = $request->description;
            $booking->counts = $request->counts;
            $booking->save();
               $activity=Activity::findOrFail($request->activity_id);
               Mail::to([$user->email])->send(new BookingNotification($booking,$user,$activity));
               Mail::to(['adhikarishishir50@gmail.com'])->send(new BookingNotificationAdmin($booking,$user,$activity));
            return response()->json([
                "status" => true,
                "message" => "Booking Created Check Mail for Details",
                "data" => $booking
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }
    public function newUserBook(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'activity_id' => 'required',
                  'email' => 'required|email',
                  'password' => 'required',
                  'name' => 'required',
                  'phone' => 'required',
                'status' => '',
                'country' => 'required',
                'arrival_date' => '',
                'departure_date' => '',
                'description' => '',
                'counts' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validator->errors()->first(),
                    "data" => [
                        'errors' => $validator->errors()->all()
                    ]
                ], 400);
            }
            // user details
             $user=new User();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->role = "user";
            $user->save();
            // booking details
            $booking = new Booking();
            $booking->activity_id = $request->activity_id;
            $booking->user_id =$user->id;
            $booking->status = "Booked";
            $booking->country = $request->country;
            $booking->arrival_date = $request->arrival_date;
            $booking->departure_date = $request->departure_date;
            $booking->description = $request->description;
            $booking->counts = $request->counts;
            $booking->save();
               $activity=Activity::findOrFail($request->activity_id);
               Mail::to([$user->email])->send(new BookingNotification($booking,$user,$activity));
                  Mail::to(['adhikarishishir50@gmail.com'])->send(new BookingNotificationAdmin($booking,$user,$activity));
            return response()->json([
                "status" => true,
                "message" => "Booking Created",
                "data" => $booking
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }
    public function show(string $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    "status" => false,
                    "message" => "Un Authorized",
                    "data" => []
                ], 401);
            }
            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json([
                    "status" => false,
                    "message" => "Booking Not Found",
                    "data" => []
                ], 404);
            }
            return response()->json([
                "status" => true,
                "message" => "Data Retrieved",
                "data" => $booking
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Internal Server Error",
                "data" => []
            ], 400);
        }
    }
    public function userBookings()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "Un Authorized",
                "data" => []
            ], 401);
        }
        $bookings = Booking::where('user_id', $user->id)->select('user_id', 'activity_id', 'status', 'country', 'arrival_date', 'departure_date', 'description', 'counts')->with('activity', 'user')->get();
        if (!$bookings) {
            return response()->json([
                "status" => false,
                "message" => "No Bookings yet",
                "data" => []
            ], 404);
        }
        return response()->json([
            "status" => true,
            "message" => "Data Retrieved",
            "data" => $bookings
        ], 200);
    }
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'activity_id' => 'required',
                'user_id' => 'required',
                'status' => 'required',
                'country' => 'required',
                'arrival_date' => '',
                'departure_date' => '',
                'description' => '',
                'counts' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validator->error()->first(),
                    "data" => [
                        'errors' => $validator->errors()
                    ]
                ], 400);
            }
            $booking = Booking::find($id);
            $booking->activity_id = $request->activity_id;
            $booking->user_id = $request->user_id;
            $booking->status = $request->status;
            $booking->country = $request->country;
            $booking->arrival_date = $request->arrival_date;
            $booking->departure_date = $request->departure_date;
            $booking->description = $request->description;
            $booking->counts = $request->counts;
            $booking->save();
            return response()->json([
                "status" => true,
                "message" => "Booking Updated",
                "data" => $booking
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Internal Server Error",
                "data" => []
            ], 400);
        }
    }
    public function destroy($id)
    {
        try {
            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json([
                    "status" => false,
                    "message" => "Booking Not Found",
                    "data" => []
                ], 404);
            }
            $booking->delete();
            return response()->json([
                "status" => true,
                "message" => "Booking Deleted",
                "data" => $booking
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Internal Server Error",
                "data" => []
            ], 400);
        }
    }
}
