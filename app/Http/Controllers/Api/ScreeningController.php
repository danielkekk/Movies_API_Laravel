<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Business\Services\ScreeningService;
use Illuminate\Validation\Rule;

class ScreeningController extends Controller
{
    protected ScreeningService $ScreeningService;

    public function __construct(ScreeningService $service)
    {
        $this->screeningService = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $screenings = $this->screeningService->getAllScreenings();

        return response()->json([
            'data' => $screenings
        ]);
    }

    /**
     * Display screenings by a movie
     */
    public function showScreeningsByMovie(string $id)
    {
        $screenings = $this->screeningService->getScreeningsByMovie($id);

        return response()->json([
            'data' => $screenings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'movies_id' => 'required|integer|exists:movies,movies_id',
            'screeining_time' => 'required|date_format:Y-m-d H:i:s',
            'available_seats' => 'required|integer',
            'url' => 'required|url:http,https|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }
        
        $screening = $this->screeningService->storeScreening($data);

        return response()->json([
            'data' => $screening
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $screening = $this->screeningService->getScreening($id);

        return response()->json([
            'data' => $screening
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $screening = $this->screeningService->getScreening($id);

        return response()->json([
            'data' => $screening
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $screening = $this->screeningService->getScreening($id);
        if (!$screening) {
            return response()->json(["error" => "Screening doesn't exist"], 404);
        }

        $data = $request->all();
        $validator = Validator::make($data,[
            'movies_id' => 'required|integer|exists:movies,movies_id',
            'screeining_time' => 'required|date_format:Y-m-d H:i:s',
            'available_seats' => 'required|integer',
            'url' => 'required|url:http,https|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }
        
        $screening = $this->screeningService->updateScreening($screening, $data);

        return response()->json([
            'data' => $screening
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $screening = $this->screeningService->getScreening($id);
        if (!$screening) {
            return response()->json(["error" => 'Screening does not exist'], 404);
        }
        
        $isDeleted = $this->screeningService->deleteScreening($screening);
        if(!$isDeleted) {
            return response()->json(["error" => 'Screening cannot be removed'], 400);
        }
    
        return response()->json(['message' => 'Screening has been deleted successfully'], 200);
    }
}
