<?php

namespace Modules\Activity\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseFormatTrait;
use Spatie\Activitylog\Models\Activity;
use Modules\Activity\Transformers\ActivityResource;

class ActivityController extends Controller
{
    use ApiResponseFormatTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $activities = Activity::all();
        return (ActivityResource::collection($activities))->additional($this->preparedResponse('index'));
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('activity::show');
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
