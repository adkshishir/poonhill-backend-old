<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function index()
    {
        try {
            $activities = Activity::all('title', 'description', 'images', 'id', 'destination_id');
            if ($activities->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Activities not found',
                    'data' => []
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Activities retrieved successfully',
                'data' => [
                    'activities' => $activities
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
    public function store(Request $request)
    {
      
        try {
            $user = Auth::user();
            // check if user is logged in
            if (!isset($user)) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => []
                ], 404);
            }
            // check if user is admin
            if ($user->role != 'admin') {
                return response()->json([
                    'status' => false,
                    'message' => 'unauthorized for this action',
                    'data' => []
                ], 401);
            }
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255|string',
                'description' => 'string',
                'introduction' => 'string|required',
                'itinerary' => 'string',
                'includes' => 'string',
                'good_to_know' => 'string',
                'images' => 'array',
                'vedio' => 'string',
                'keywords' => 'array',
                'keywords.*' => 'string',
                'price' => 'string',
                'duration' => 'string',
                'altitude' => 'string',
                'start_from' => 'string',
                'end_at' => 'string',
                'attraction' => 'string',
                'rating' => 'string',
                "culture" => 'string',
                'food' => 'string',
                'transportation' => 'string',
                'accomodation' => 'string',
                'group_size' => 'string',
                'group_type' => 'string',
                'destination_id' => 'required|exists:destinations,id',
                'images.*' => 'string',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 400);
            }

            $activity = Activity::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Activity created successfully',
                'data' => [
                    'activity' => $activity
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
    public function show(string $id)
    {
        try {
            // $activity = Activity::findOrFail($id);
            $activity = Activity::where('title', $id)->first();
            if (!$activity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Activity not found',
                    'data' => []
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Activity retrieved successfully',
                'data' => [
                    'activity' => $activity
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        // check if user is logged in
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }
        // check if user is admin
        if ($user->role != 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'unauthorized for this action',
                'data' => []
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|string',
            'description' => 'string',
            'introduction' => 'string|required',
            'itinerary' => 'string',
            'includes' => 'string',
            'good_to_know' => 'string',
            'images' => 'array',
            'images.*' => 'string',
            'vedio' => 'string',
            'price' => 'string',
            'duration' => 'string',
            'altitude' => 'string',
            'start_from' => 'string',
            'end_at' => 'string',
            'attraction' => 'string',
            'rating' => 'string',
            "culture" => 'string',
            'food' => 'string',
            'transportation' => 'string',
            'accomodation' => 'string',
            'group_size' => 'string',
            'group_type' => 'string',
            'destination_id' => 'required|exists:destinations,id',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $activity = Activity::find($id);
            if (!$activity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Activity not found',
                    'data' => []
                ], 404);
            }
            $activity->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Activity updated successfully',
                'data' => [
                    'activity' => $activity
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    
    }
    public function destroy($id)
    {
        $user = auth()->user();
        // check if user is logged in
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }
        // check if user is admin
        if ($user->role != 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'unauthorized for this action',
                'data' => []
            ], 401);
        }
        try {
            $activity = Activity::find($id);
            if (!$activity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Activity not found',
                    'data' => []
                ], 404);
            }
            $activity->delete();
            return response()->json([
                'status' => true,
                'message' => 'Activity deleted successfully',
                'data' => [
                    'activity' => $activity
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
