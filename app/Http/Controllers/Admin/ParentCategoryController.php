<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParentCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parentActivities = ParentActivity::with("destination")->get();
        $response['status'] = true;
        $response['message'] = "Parent Activities retrieved successfully";
        $response['data']['parentActivities'] = $parentActivities;
        return view("admin.parent-activity.index", $response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.parent-activity.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|string|unique:parent_activities',
                'description' => 'required|string',
                'image' => 'string',
                'destination_id' => 'required|exists:destinations,id',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            $parentActivity = new ParentActivity();
            $parentActivity->name = $request->name;
            $parentActivity->description = $request->description;
            $parentActivity->image = $request->image;
            $parentActivity->destination_id = $request->destination_id;
            $parentActivity->save();
            $response['status'] = true;
            $response['message'] = "Parent Activity created successfully";
            $response['data']['parentActivity'] = $parentActivity;
            return view("admin.parent-activity.view", $response);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $parentActivity = ParentActivity::find($id);
        $response['status'] = true;
        $response['message'] = "Parent Activity retrieved successfully";
        $response['data']['parentActivity'] = $parentActivity;
        return view("admin.parent-activity.show", $response);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $parentActivity = ParentActivity::find($id);
        $response['status'] = true;
        $response['message'] = "Parent Activity retrieved successfully";
        $response['data']['parentActivity'] = $parentActivity;
        return view("admin.parent-activity.edit", $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $parentActivity = ParentActivity::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|string|unique:parent_activities',
            'description' => 'required|string',
            'image' => 'string',
            'destination_id' => 'required|exists:destinations,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $parentActivity->name = $request->name;
        $parentActivity->description = $request->description;
        $parentActivity->image = $request->image;
        $parentActivity->destination_id = $request->destination_id;
        $parentActivity->save();
        $response['status'] = true;
        $response['message'] = "Parent Activity updated successfully";
        $response['data']['parentActivity'] = $parentActivity;
        return view("admin.parent-activity.show", $response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $parentActivity = ParentActivity::find($id);
        $parentActivity->delete();
        $response['status'] = true;
        $response['message'] = "Parent Activity deleted successfully";
        $response['data']['parentActivity'] = $parentActivity;
        return view("admin.parent-activity.index", $response);
    }
}
