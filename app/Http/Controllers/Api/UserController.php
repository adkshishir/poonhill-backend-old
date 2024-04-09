<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        // check if the user is authenticated
        if (auth()->user()) {
            if (auth()->user()->role == 'admin') {
                return response()->json([
                    'status' => true,
                    'message' => 'User found',
                    'data' => [
                        'users' => $user
                    ]
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'unauthorized for this action',
                'data' => []
            ], 401);
        }

        return response()->json([
            'status' => false,
            'message' => 'No Users found in the database',
            'data' => []
        ], 404);
    }
    public function checkAdmin()
    {
        // dd('here');
       try{
        // dd(auth()->user());
        $user=auth()->user();
        if($user->role=='admin'){
            return response()->json([
                'status' => true,
                'message' => 'User found',
                'data' => [
                    'user' => $user
                ]
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'unauthorized for this action',
            'data' => []
        ], 401);
       }
       catch(Exception $e){
        return response()->json([
            'status' => false,
            'message' => 'unauthorized for this action',
            'data' => []
        ], 401);
       }
    }

    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'phone' => 'numeric|min:10',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => [
                    'email' => $validator->errors()->all(),
                ]
            ], 400);
        }
        try {
            if (User::where('email', $request->email)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'User already exists',
                    'data' => [],
                ], 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone
            ]);
            $token = $user->createToken('authToken');
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user,
                'token' => [
                    'access_token' => $token->accessToken,
                    'token_type' => 'Bearer',
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => [
                    'email' => $validator->errors()->all(),
                ]
            ], 400);
        }
        try {
            $user = User::where('email', $request->email)->first();
            if (!isset($user)) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => [],
                ], 400);
            }
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid password',
                    'data' => [],
                ], 401);
            }
            $token = $user->createToken('authToken');
            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'data' => $user,
                'token' => [
                    'access_token' => $token->accessToken,
                    'token_type' => 'Bearer',
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    public function logout()
    {   
        auth()->user()->token()->revoke();
        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully',
            'data' => [],
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all, [
            'email' => "required|email",
            "old_password" => 'required|min:6',
            "new_password" => "required|min:6",
            "confirm_password" => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors()->first(),
                'errors' => ['errors' => $validator->errors()->all()]
            ]);
        }
        $user = User::where('email', $request->email)->first();
        if (!isset($user)) {
            return response()->json([
                'status' => false,
                'message' => 'Email Not Found Try another Email',
                'data' => [],
            ]);
        }
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Old password is Wrong',
                'data' => [],
            ], 400);
        }
        $user->password = bcrypt($request->new_password);
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'Password Changed Successfully',
            'data' => [],
        ], 200);
    }
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()->all()
            ]);
        }
        $user = User::where("email", $request->email)->first();
        if (!isset($user)) {
            return response()->json([
                'status' => false,
                'message' => 'Email Not Found Try another Email',
                'data' => [],
            ]);
        }
        $userAlreadyExist = PasswordReset::where('email', $request->email)->first();
        $token = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 60);
        if (isset($userAlreadyExist)) {
            // Update the token in PasswordReset table
            PasswordReset::where('email', $request->email)->update([
                'token' => $token,
                'updated_at' => Carbon::now()
            ]);
        } else {
            // save token to database (password_reset_tokens table);
            PasswordReset::create([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        Mail::to($user->email)->send(new VerifyEmail(base64_encode($user->email), $token,$user));

        return response()->json([
            'status' => true,
            'message' => 'Password reset link sent to your email',
            'data' => [],
        ], 200);
    }

    public function resetPassword(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()->all()
            ]);
        }
        try {
            $resetToken = PasswordReset::where('email', $request->email)->first();

            if (!isset($resetToken)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Token',
                    'data' => [],
                ], 400);
            }
            if (Carbon::parse($resetToken->updated_at)->addMinutes(180)->isPast()) {
                $resetToken->delete();
                return response()->json([
                    'status' => false,
                    'message' => 'Token Expired',
                    'data' => [],
                ], 400);
            }

            if ($resetToken->token != $token) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Token',
                    'data' => [],
                ], 400);
            }
            $user = User::where('email', $request->email)->first();

            if (!isset($user)) {
                return response()->json([
                    'status' => false,
                    'message' => 'User Not Found',
                    'data' => [],
                ], 404);
            }

            $user->password = bcrypt($request->new_password);

            $user->update();
            // delete the user with email is exists
            PasswordReset::where('email', $request->email)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Password Changed Successfully',
                'data' => [],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => [
                    'error' => "internal server error"
                ],
            ], 500);
        }
    }

}
