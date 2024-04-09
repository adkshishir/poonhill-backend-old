<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Views;
use Exception;
use Illuminate\Http\Request;

class ViewsController extends Controller
{
    function index()
    {
        $views = Views::all();
        if ($views) {
            return response()->json([
                'status' => 200,
                'views' => $views
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No views found'
            ]);
        }
    }

    function store(Request $request)
    {
        if (!$request->url) {
            return response()->json([
                'status' => 400,
                'message' => 'Url is required'
            ], 400);
        }
        try {
            $view = Views::where('url', $request->url)->first();
            //   dd($view);
            if ($view) {
                $view->increment('count');
                return response()->json([
                    'status' => 200,
                    'message' => 'View count incremented',
                    'data' => $view
                ], 200);
            } else {
                $view = Views::create([
                    'url' => $request->url,
                    'count' => 1
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'View created',
                    'data' => $view
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
