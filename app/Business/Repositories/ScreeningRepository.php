<?php

namespace App\Business\Repositories;

use App\Models\Movie;
use App\Models\Screening;

class ScreeningRepository
{
    public function getAll()
    {
        return Screening::all();
    }

    public function getAllByMovieId(string $id)
    {
        $movie = Movie::find($id);
        if(!$movie) {
            return null;
        }

        return $movie->screenings;
    }

    public function getById(string $id)
    {
        return Screening::find($id);
    }

    public function save(array $data):Screening
    {
        return Screening::create($data);
    }

    public function update(Screening $screening, array $data):Screening
    {
        $screening->update($data);

        return $screening;
    }

    public function delete(Screening $screening):bool
    {
        return $screening->delete();
    }
}