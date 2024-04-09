<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    function index()
    {
        try {
            $images = Image::all();
            if ($images) {
                return response()->json([
                    'status' => true,
                    'data' => $images
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'No images found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error"
            ], 500);
        }
    }
    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'array',
            'images.*' => 'string',
            'title'=>'array',
            'title.*'=>'string',
            

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        } else {
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
                //  decode base 64 images
                // dd($request->images);
                $images=$request->images;
                for($i=0;$i<count($images);$i++){
                    // if image are not base64 and not image
                    $base64_images = $images[$i];
                    $base64_images = str_replace('data:image/jpeg;base64,', '', $base64_images);
                    $base64_images = str_replace('data:image/png;base64,', '', $base64_images);
                    $base64_images = str_replace('data:image/jpg;base64,', '', $base64_images);
                    $base64_images = str_replace('data:image/gif;base64,', '', $base64_images);
                    $base64_images = str_replace(' ', '+', $base64_images);
                    $image = base64_decode($base64_images);
                    
                    $image_name = $request->title[$i];
                    $path = 'images/' . $image_name;
                    Storage::put("public/" . $path, $image);
                    $image = new Image();
                    // $image->alt = $image_name;
                    // remove jpg and add to alt 
                    $image->alt = str_replace(['.jpg', '.jpeg', '.png', '.gif'], '', $image_name);
                    
                    $image->title = $image_name;
                    $image->path = "storage/" . $path;
                    
                    $image->save();
                }
               
                // foreach ($images as $image) {
                //     $base64_images = $image;
                //     // if image are not base64 and not image
                //     $base64_images = str_replace('data:image/jpeg;base64,', '', $base64_images);
                //     $base64_images = str_replace('data:image/png;base64,', '', $base64_images);
                //     $base64_images = str_replace('data:image/jpg;base64,', '', $base64_images);
                //     $base64_images = str_replace('data:image/gif;base64,', '', $base64_images);
                //     $base64_images = str_replace(' ', '+', $base64_images);
                //     $image = base64_decode($base64_images);
                //     // get the name of the image from  base64 string
                          
                //     // $image_name=uniqid().'.jpg';
                //     $image_name=''
                //     $path = 'images/' . $image_name;
                //     Storage::put("public/" . $path, $image);
                //     $image = new Image();
                //     $image->alt = $request->alt;
                //     $image->title = $image_name;
                //     // $image->path = "storage/" . $path;
                    
                //     $image->save();
                // }
                return response()->json([
                    'status' => true,
                    'message' => 'Images uploaded successfully',
                    'data' => [
                        'images' => $image
                    ]
                ], 200);
                // $base64_images = $request->images;
                // $base64_images = str_replace('data:image/jpeg;base64,', '', $base64_images);
                // $base64_images = str_replace('data:image/png;base64,', '', $base64_images);
                // $base64_images = str_replace('data:image/jpg;base64,', '', $base64_images);
                // $base64_images = str_replace('data:image/gif;base64,', '', $base64_images);
                // $base64_images = str_replace(' ', '+', $base64_images);
                // $image = base64_decode($base64_images);
                // $image_name = time() . '.' . 'jpg';
                // $path = 'images/' . $image_name;
                // Storage::put("storage/".$path, $image);
                // $image = new Image();

            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    }
    function destroy($id)
    {

        $image = Image::find($id);
        if (!$image) {
            return response()->json([
                'status' => false,
                'message' => 'Image not found',
                'data' => []
            ], 404);
        }
        $image->image = str_replace('public/images', '', $image->image);
        Storage::delete($image->image);
        $image->delete();
        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully',
            'data' => [
                'image' => $image

            ]
        ], 200);
    }
}
