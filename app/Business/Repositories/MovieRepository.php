<?php

namespace App\Business\Repositories;

use App\Models\Movie;

class MovieRepository
{
    public function getAll()
    {
        return Movie::all();
    }

    public function getById(string $id)
    {
        return Movie::find($id);
    }

    public function save(array $data):Movie
    {
        return Movie::create($data);
    }

    public function update(Movie $movie, array $data):Movie
    {
        $movie->update($data);

        return $movie;
    }

    public function delete(Movie $movie):bool
    {
        return $movie->delete();
    }
}