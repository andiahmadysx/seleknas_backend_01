<?php

namespace App\Http\Controllers;

use App\Models\JobValidation;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    //
    public function store(Request $request)
    {

        $validation = JobValidation::updateOrCreate([
           'work_experience' => $request->work_experience,
            'job_position' => $request->job_position,
            'reason_accepted' => $request->reason_accepted,
            'job_category_id' => $request->job_category_id,
            'society_id' => $request->society->id
        ]);

        return response()->json( ['message' => "Request data validation sent successful"]);
    }

    public function index(Request $request)
    {
        $validaton = JobValidation::with('validator')->where('society_id', $request->society->id)->first();

        $validaton->makeHidden(['society_id', 'job_category_id']);
        return response()->json(['validation' => $validaton]);
    }
}
