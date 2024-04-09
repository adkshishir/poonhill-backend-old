<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
    public function index()
    {
        try {

            $destination = Destination::all();
            if ($destination->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Destination not found',
                    'data' => []
                ], 404);
            }
            return response()->json([
                'status' => true,
                'data' => [
                    'destination' => $destination
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
            $vaidator = Validator::make($request->all(), [
                'name' => 'required|max:255|string|unique:destinations',
                'description' => 'required|string',
                'image' => 'required',
                'parent_activity_id' => 'required|exists:parent_activities,id',

            ]);

            if ($vaidator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $vaidator->errors()->first(),
                    'errors' => $vaidator->errors(),
                ], 400);
            }
            // decode the image string into base64

            // $imagePath = '';
            // if($request->input('image') != null){
            //     $image = base64_decode($request->input('image'));
            //     $imagePath = 'storage/images/destinations/' . time() . '.png';
            //     file_put_contents($imagePath, $image);
            //     Image::create([
            //        "path"=>$imagePath,
            //        "alt"=>$request->name,
            //        "title"=>"destination image"
            //     ]);
            // }

            // save image in storage and get path
            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $imagePath = $image->store('storage/images/destinations', 'public');
            //     $request['image'] = $imagePath;

            // }

            $destination = Destination::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image,
                'parent_activity_id' => $request->parent_activity_id

            ]);
            return response()->json([
                'status' => true,
                'message' => 'Destination created successfully',
                'data' => [
                    'destination' => $destination
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
            $destination = Destination::where('name', $id)->first();
            $activity = Activity::where('destination_id', $destination->id)->get(['title', 'description', 'images', 'destination_id', 'id','duration','group_size','price']);
            if (!$destination) {
                return response()->json([
                    'status' => false,
                    'message' => 'Destination not found',
                    'data' => []
                ], 404);
            }
            return response()->json([
                'status' => true,
                'data' => [
                    'destination' => $destination,
                    'activities' => $activity
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
        try {
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
            // 
            $vaidator = Validator::make($request->all(), [
                'name' => 'required|max:255|string|unique:destinations',
                'description' => 'required|string',
                'image' => 'required|string',
                'parent_activity_id' => 'required|exists:parent_activities,id',

            ]);
            if ($vaidator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $vaidator->errors()->first(),
                    'errors' => $vaidator->errors(),
                ], 400);
            }
            $destination = Destination::find($id);
            // save image in storage and get path
            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $imagePath = $image->store('storage/images/destinations', 'public');
            //     $request['image'] = $imagePath;

            // }
            $destination->update([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image,
                'parent_activity_id' => $request->parent_activity_id
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Destination updated successfully',
                'data' => [
                    'destination' => $destination
                ],
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
        $destination = Destination::find($id);
        $destination->delete();
        return response()->json([
            'status' => true,
            'message' => 'Destination deleted successfully',
            'data' => [
                'destination' => $destination
            ]
        ], 200);
    }
}
