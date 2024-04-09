<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\ParentActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParentActivityController extends Controller
{
    public function index()
    {
        $parentActivities = ParentActivity::with("destination")->get();
        if ($parentActivities->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Parent Activities not found',
                'data' => []
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Parent Activities retrieved successfully',
            'data' => [
                'parentActivities' => $parentActivities
            ]
        ], 200);
    }
    public function store(Request $request)
    {
        $user = auth()->user();

        // check if user is logged in
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 401);
        }

        // check if user is admin
        if ($user->role != 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'User not authorized',
                'data' => []
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|string|unique:parent_activities',
            'description' => 'required|string',
            'image' => 'string',
            'package_id' => 'required|exists:packages,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            $parentActivity = ParentActivity::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Parent Activity created successfully',
                'data' => [
                    'parentActivity' => $parentActivity
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
            $parentActivity = ParentActivity::where('name', $id)->first();
            if (!$parentActivity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Parent Activity not found',
                    'data' => []
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Parent Activity retrieved successfully',
                'data' => [
                    'parentActivity' => $parentActivity,
                    'destination' => Destination::where('parent_activity_id', $parentActivity->id)->get(['id', 'name','image'])
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
                'message' => 'User not authorized',
                'data' => []
            ], 401);
        }
        try {
            $parentActivity = ParentActivity::find($id);
            if (!$parentActivity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Parent Activity not found',
                    'data' => []
                ], 404);
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|string|unique:parent_activities',
                'description' => 'required|string',
                'image' => 'string',
                'package_id' => 'required|exists:packages,id',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 400);
            }

            $parentActivity->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Parent Activity updated successfully',
                'data' => [
                    'parentActivity' => $parentActivity
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
            $parentActivity = ParentActivity::find($id);
            $parentActivity->delete();
            return response()->json([
                'status' => true,
                'message' => 'Parent Activity deleted successfully',
                'data' => [
                    'parentActivity' => $parentActivity
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
