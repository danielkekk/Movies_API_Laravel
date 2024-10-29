<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business\Services\ScreeningService;

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
        $result = ['status' => 200];

        try {
            $result['data'] = $this->screeningService->getAllScreenings();
        } catch(\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display screenings by a movie
     */
    public function showScreeningsByMovie(string $id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->screeningService->getScreeningsByMovie($id);
        } catch(\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $result = ['status' => 201];

        try {
            $result['data'] = $this->screeningService->storeScreening($data);
        } catch(\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->screeningService->getScreening($id);
        } catch(\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->screeningService->getScreening($id);
        } catch(\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $result = ['status' => 200];

        try {
            $result['data'] = $this->screeningService->updateScreening($id, $data);
        } catch(\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = [
            'status' => 200,
            'message' => 'Screening has been deleted successfully',
        ];

        try {
            $result['data'] = $this->screeningService->deleteById($id);
        } catch(\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}
