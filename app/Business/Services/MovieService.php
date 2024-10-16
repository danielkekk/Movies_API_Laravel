<?php

namespace App\Business\Services;

use App\Models\Movie;
use App\Business\Repositories\MovieRepository;
use Illuminate\Testing\Exceptions\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use App\Enums\AgeRating;
use App\Enums\Language;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MovieService
{
    protected MovieRepository $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function getAllMovies()
    {
        return $this->movieRepository->getAll();
    }

    public function getMovie(string $id)
    {
        return $this->movieRepository->getById($id);
    }

    public function storeMovie(array $data):Movie
    {
        $validator = Validator::make($data,[
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'age_rating' => [Rule::enum(AgeRating::class)],
            'lang' => [Rule::enum(Language::class)],
            'cover_img' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->movieRepository->save($data);
    }

    public function updateMovie(string $id, array $data):Movie
    {
        $validator = Validator::make($data,[
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'age_rating' => [Rule::enum(AgeRating::class)],
            'lang' => [Rule::enum(Language::class)],
            'cover_img' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $movie = $this->movieRepository->getById($id);
            if (!$movie) {
                throw new \Exception("Movie doesn't exist");
            }

            $result = $this->movieRepository->update($movie, $data);
        } catch(\Exception $e) {
            DB::rollBack();
            
            throw new InvalidArgumentException("Unable to update movie");
        }

        DB::commit();

        return $result;
    }

    public function deleteById(string $id):bool
    {

        DB::beginTransaction();

        try {
            $movie = $this->movieRepository->getById($id);
            if (!$movie) {
                throw new InvalidArgumentException("Movie does not exist");
            }

            $deleted = $this->movieRepository->delete($movie);

        } catch(\Exception $e) {
            DB::rollBack();

            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        DB::commit();

        return $deleted;
    }
}