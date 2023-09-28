<?php

namespace App\Http\Controllers;

use App\Models\AvailablePosition;
use App\Models\JobApplyPosition;
use App\Models\JobApplySociety;
use App\Models\JobValidation;
use App\Models\Society;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplyJobController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vacancy_id' => 'required',
            'positions' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ]);
        }

        $validation = JobValidation::where('society_id', $request->society->id)->first();

        if ($validation->status != 'accepted') {
            return response()->json([
                "message" => "Your data validator must be accepted by validator before"
            ], 401);
        }


        $applySociety = JobApplySociety::where('society_id', $request->society->id)->first();

        if ($applySociety) {
            return response()->json([
                "message" => "Application for a job can only be once"
            ], 401);
        }

        $applySociety = JobApplySociety::create([
            'notes' => @$request->notes,
            'date' => Carbon::now(),
            'society_id' => $request->society->id,
            'job_vacancy_id' => $request->vacancy_id
        ]);

        $position_id = [];

        if(!is_array($request->positions)){
            $request->positions = explode(',', $request->positions);
            foreach ($request->positions as $index => $position) {

                $availablePosId = @AvailablePosition::where('position', trim($position))->first()->id;

                if ($availablePosId) {
                    $position_id[] = $availablePosId;
                }
            }
        }


        foreach ($position_id as $pos_id) {
            JobApplyPosition::create([
                'date' => Carbon::now(),
                'society_id' => $request->society->id,
                'job_vacancy_id' => $request->vacancy_id,
                'position_id' => $pos_id,
                'job_apply_societies_id' => $applySociety->id
            ]);
        }

        return response()->json(["message" => "Applying for job successful"]);
    }

    public function index(Request $request)
    {
        $jobApplySociety = JobApplySociety::with(["jobVacancy.category", "jobVacancy.jobApplyPosition" => function($query) use ($request){
            $query->with('availablePosition')->where('society_id', '=', $request->society->id);
        }])->get();


        $data = [];

        foreach ($jobApplySociety as $index => $apply) {
            $apply->jobVacancy->makeHidden(['job_category_id']);

            $post = [];

            foreach ($apply->jobVacancy->jobApplyPosition as $index => $item) {
                $post[] = ["position" => $item->availablePosition->position, "apply_status" => $item->status, "notes" => $item->notes];
            }

            $apply->jobVacancy->position = $post;

            $apply->jobVacancy->makeHidden(['jobApplyPosition']);


            $data[] = collect($apply->jobVacancy);
        }
        return response()->json(["vacancies" => $data]);
    }
}
