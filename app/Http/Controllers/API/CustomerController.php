<?php

namespace App\Http\Controllers\API;

use App\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CustomerController extends Controller
{
    use ApiHelper;

    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * list of customers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $customers = $this->customerRepository->index();

            return $this->onSuccess($customers, 'Customers fetched successfully!');
        } catch (\Exception $e) {
            Log::error('Error in fetching customers '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * store Customer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomerRequest $request)
    {
        try {
            $customer = $this->customerRepository->store($request->all());
            Log::info('Customer created successfully '.json_encode($customer));

            return $this->onSuccess($customer, 'Customer created successfully');
        } catch (\Exception $e) {
            Log::error('Error in create Customer '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * update Customer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CustomerRequest $request, $customerId)
    {
        try {
            $customer = $this->customerRepository->update($request->all(), $customerId);
            Log::info('Customer updated successfully '.json_encode($customer));

            return $this->onSuccess($customer, 'Customer updated successfully');
        } catch (\Exception $e) {
            Log::error('Error in update Customer '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * get specific Customer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($customerId)
    {
        try {
            $customer = $this->customerRepository->find($customerId);
            Log::info('Customer found '.json_encode($customer));

            return $this->onSuccess($customer, 'Customer found');
        } catch (\Exception $e) {
            Log::error('Error in find Customer '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * delete customers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($customerId)
    {
        try {
            if (Auth::user()->role == 'owner') {
                $this->customerRepository->forceDelete($customerId);
            } else {
                $this->customerRepository->delete($customerId);
            }

            Log::info('Customer deleted ');

            return $this->onSuccess('', 'Customer deleted successfully !');
        } catch (\Exception $e) {
            Log::error('Error in delete Customer '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
