<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Business\Services\MovieService;
use App\Enums\AgeRating;
use App\Enums\Language;
use Illuminate\Validation\Rule;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $service)
    {
        $this->movieService = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = $this->movieService->getAllMovies();

        return response()->json([
            'data' => $movies
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'age_rating' => [Rule::enum(AgeRating::class)],
            'lang' => [Rule::enum(Language::class)],
            'cover_img' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }
        
        $movie = $this->movieService->storeMovie($data);

        return response()->json([
            'data' => $movie
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = $this->movieService->getMovie($id);

        return response()->json([
            'data' => $movie
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movie = $this->movieService->getMovie($id);

        return response()->json([
            'data' => $movie
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $movie = $this->movieService->getMovie($id);
        if (!$movie) {
            return response()->json(["error" => "Movie doesn't exist"], 404);
        }

        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'age_rating' => [Rule::enum(AgeRating::class)],
            'lang' => [Rule::enum(Language::class)],
            'cover_img' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }
        
        $movie = $this->movieService->updateMovie($movie, $data);

        return response()->json([
            'data' => $movie
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = $this->movieService->getMovie($id);
        if (!$movie) {
            return response()->json(["error" => 'Movie does not exist'], 404);
        }
        
        $isDeleted = $this->movieService->deleteMovie($movie);
        if(!$isDeleted) {
            return response()->json(["error" => 'Movie cannot be removed'], 400);
        }
    
        return response()->json(['message' => 'Movie has been deleted successfully'], 200);
    }
}
