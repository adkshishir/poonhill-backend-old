<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function index()
    {
        try {
            $packages = Package::all();
            if ($packages->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Packages not found',
                    'data' => []
                ], 404);
            }
            return response()->json([
                'status' => true,
                'data' => [
                    'packages' => $packages
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|string|unique:packages',
            'description' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => [
                    'name' => $validator->errors()->all(),
                ]
            ], 400);
        }
        try {
            $package = Package::create([
                'name' => $request->name,
                'description' => $request->description,

            ]);
            return response()->json([
                'status' => true,
                'message' => 'Package created successfully',
                'data' => [
                    'package' => $package
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
    public function show(string $title)
    {

        try {
            $package = Package::where('name', $title)->first();
            if (!$package) {
                return response()->json([
                    'status' => false,
                    'message' => 'Package not found',
                    'data' => []
                ], 404);
            }
            return response()->json([
                'status' => true,
                'data' => [
                    'package' => $package
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|string|unique:packages',
            'description' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => [
                    'name' => $validator->errors()->all(),
                ]
            ], 400);
        }
        try {
            $package = Package::find($id);
            $package->update([
                'name' => $request->name,
                'description' => $request->description,

            ]);
            return response()->json([
                'status' => true,
                'message' => 'Package updated successfully',
                'data' => [
                    'package' => $package
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
                'message' => 'User not authorized',
                'data' => []
            ], 401);
        }
        try {
            $package = Package::find($id);
            $package->delete();
            return response()->json([
                'status' => true,
                'message' => 'Package deleted successfully',
                'data' => [
                    'package' => $package
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
