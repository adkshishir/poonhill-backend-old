<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Destination;
use App\Models\ParentActivity;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function parent_activity()
    {
        try {
            $parentActivities = ParentActivity::all(['id', 'name']);
            if ($parentActivities->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Parent Activities not found',
                    'data' => []
                ], 404);
            }
            $data = [];

            foreach ($parentActivities as $activity) {
                $destinations = Destination::where('parent_activity_id', $activity->id)->get(['id', 'name']);
                $destinationsData = [];

                foreach ($destinations as $destination) {
                    $activities = Activity::where('destination_id', $destination->id)->get(['id', 'title']);

                    // if ($activities->isEmpty()) {
                    //     continue;
                    // }

                    $activitiesData = [];

                    foreach ($activities as $act) {
                        $activitiesData[] = [
                            'id' => $act->id,
                            'label' => $act->title,
                        ];
                    }

                    $destinationsData[] = [
                        'key' => $destination->id,
                        'label' => $destination->name,
                        'children' => $activitiesData,
                    ];
                }

                $data[] = [
                    'key' => $activity->id,
                    'name' => $activity->name,
                    'children' => $destinationsData,
                ];
            }

            return response()->json([
                "status" => true,
                "data" => [
                    'parent_activities' => $data
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

    public function destination($id)
    {
        $destination = Destination::where('parent_activity_id', $id)->get(['id', 'name']);
        $activites = Activity::all(['id', 'title', 'destination_id']);
        $data = [];
        foreach ($destination as $values) {
            $data[] = [
                'id' => $values->id,
                'name' => $values->name,
                'activities' => $activites->where('destination_id', $values->id)
            ];
        }
        return response()->json([
            "status" => true,
            'data' => [
                'destination' => $data
            ]
        ], 200);
    }



    public function search()
    {
        $destination = Destination::with('activities')->get(['id', 'name']);

        function search($destination)
        {
            $data = [];
            foreach ($destination as $values) {

                foreach ($values->activities as $value) {
                    $data[] = [
                        'destination_name' => $values->name,
                        'activity_id' => $value->id,
                        'activity_name' => $value->title,

                    ];
                }
            }
            return $data;
        }
        return response()->json([
            "status" => true,
            "data" => [
                "destination" => search($destination)
            ]
        ], 200);
    }
}
