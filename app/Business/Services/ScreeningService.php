<?php

namespace App\Business\Services;

use App\Models\Screening;
use Illuminate\Testing\Exceptions\InvalidArgumentException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Business\Repositories\ScreeningRepository;
use Illuminate\Support\Facades\DB;

class ScreeningService
{
    protected ScreeningRepository $screeningRepository;

    public function __construct(ScreeningRepository $screeningRepository)
    {
        $this->screeningRepository = $screeningRepository;
    }

    public function getAllScreenings()
    {
        return $this->screeningRepository->getAll();
    }

    public function getScreeningsByMovie($id)
    {
        $result = $this->screeningRepository->getAllByMovieId($id);
        if(!$result) {
            throw new \Exception("Screenings are not available");
        }

        return $result;
    }

    public function getScreening(string $id)
    {
        return $this->screeningRepository->getById($id);
    }

    public function storeScreening(array $data):Screening
    {
        $validator = Validator::make($data, [
            'movies_id' => 'required|integer|exists:movies,movies_id',
            'screeining_time' => 'required|date_format:Y-m-d H:i:s',
            'available_seats' => 'required|integer',
            'url' => 'required|url:http,https|max:255',
        ]);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->screeningRepository->save($data);
    }

    public function updateScreening(string $id, array $data):Screening
    {
        $validator = Validator::make($data,[
            'movies_id' => 'required|integer|exists:movies,movies_id',
            'screeining_time' => 'required|date_format:Y-m-d H:i:s',
            'available_seats' => 'required|integer',
            'url' => 'required|url:http,https|max:255',
        ]);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $screening = $this->screeningRepository->getById($id);
            if (!$screening) {
                throw new \Exception("Screening doesn't exist");
            }

            $result = $this->screeningRepository->update($screening, $data);
        } catch(\Exception $e) {
            DB::rollBack();
            
            throw new InvalidArgumentException("Unable to update movie");
        }

        DB::commit();

        return $result;
    }

    public function deleteById(string $id):bool
    {
        $screening = $this->screeningRepository->getById($id);
        if (!$screening) {
            throw new \Exception("Screening does not exist");
        }
        
        return $this->screeningRepository->delete($screening);
    }
}