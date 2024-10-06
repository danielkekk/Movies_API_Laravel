<?php

namespace App\Business\Services;

use App\Models\Movie;

class MovieService
{
    public function getAllMovies()
    {
        $result = Movie::all();

        return $result;
    }

    public function getMovie(string $id)
    {
        $result = Movie::find($id);

        return $result;
    }

    public function storeMovie(array $data):Movie
    {
        $result = Movie::create($data);

        return $result;
    }

    public function updateMovie(Movie $movie, array $data):Movie
    {
        $movie->update($data);

        return $movie;
    }

    public function deleteMovie(Movie $movie):bool
    {
        return $movie->delete();
    }
}