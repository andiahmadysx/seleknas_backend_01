<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use App\Models\JobValidation;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function index(Request $request)
    {
        $validation = JobValidation::where('society_id', $request->society->id)->first();

        if ($validation->status != 'accepted') {
            return response()->json([
                "vacancies" => []
            ]);
        }

        $vacancies = JobVacancy::with('category', 'availablePositions')->where('job_category_id', $validation->job_category_id)->get();


        foreach ($vacancies as $index => $vacancy) {
            $vacancy->makeHidden(['job_category_id',]);


            foreach ($vacancy->availablePositions as $index => $availablePosition) {
                $availablePosition->makeHidden(['id', 'job_vacancy_id']);
            }
        }
        return response()->json(['vacancies' => $vacancies]);
    }

    public function show(Request $request, $id)
    {
        $vacancy = JobVacancy::with('category', 'availablePositions.jobApplyPositions')->where('id', $id)->first();
        $vacancy->makeHidden(['job_category_id',]);
        $vacancy->availablePositions->makeHidden(['id', 'job_vacancy_id']);

        foreach ($vacancy->availablePositions as $index => $availablePosition) {
            $availablePosition->apply_count =  $availablePosition->jobApplyPositions->count();
            $availablePosition->makeHidden('jobApplyPositions');

        }
        return response()->json(['vacancy' => $vacancy]);
    }
}
