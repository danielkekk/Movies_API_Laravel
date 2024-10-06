<?php

namespace App\Business\Services;

use App\Models\Movie;
use App\Models\Screening;

class ScreeningService
{
    public function getAllScreenings()
    {
        $result = Screening::all();

        return $result;
    }

    public function getScreeningsByMovie($id)
    {
        $movie = Movie::find($id);

        return $movie->screenings;
    }

    public function getScreening(string $id)
    {
        $result = Screening::find($id);

        return $result;
    }

    public function storeScreening(array $data):Screening
    {
        $result = Screening::create($data);

        return $result;
    }

    public function updateScreening(Screening $screening, array $data):Screening
    {
        $screening->update($data);

        return $screening;
    }

    public function deleteScreening(Screening $screening):bool
    {
        return $screening->delete();
    }
}