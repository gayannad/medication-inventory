<?php

namespace App\Http\Controllers\API;

use App\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MedicationRequest;
use App\Interfaces\MedicationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MedicationController extends Controller
{
    use ApiHelper;

    private MedicationRepositoryInterface $medicationRepository;

    public function __construct(MedicationRepositoryInterface $medicationRepository)
    {
        $this->medicationRepository = $medicationRepository;
    }

    /**
     * list of medications
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $medications = $this->medicationRepository->index();

            return $this->onSuccess($medications, 'Medications fetched successfully!');
        } catch (\Exception $e) {
            Log::error('Error in fetching medications '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * store medication
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MedicationRequest $request)
    {
        try {
            $medication = $this->medicationRepository->store($request->all());
            Log::info('Medication created successfully '.json_encode($medication));

            return $this->onSuccess($medication, 'Medication created successfully');
        } catch (\Exception $e) {
            Log::error('Error in create medication '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * update medication
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MedicationRequest $request, $medicationId)
    {
        try {
            $medication = $this->medicationRepository->update($request->all(), $medicationId);
            Log::info('Medication created successfully '.json_encode($medication));

            return $this->onSuccess($medication, 'Medication updated successfully');
        } catch (\Exception $e) {
            Log::error('Error in update medication '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * get specific medication
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($medicationId)
    {
        try {
            $medication = $this->medicationRepository->find($medicationId);
            Log::info('Medication found '.json_encode($medication));

            return $this->onSuccess($medication, 'Medication found');
        } catch (\Exception $e) {
            Log::error('Error in find medication '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * delete medications
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($medicationId)
    {
        try {
            if (Auth::user()->role == 'owner') {
                $this->medicationRepository->forceDelete($medicationId);
            } else {
                $this->medicationRepository->delete($medicationId);
            }

            Log::info('Medication deleted ');

            return $this->onSuccess('', 'Medication deleted successfully !');
        } catch (\Exception $e) {
            Log::error('Error in delete medication '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
