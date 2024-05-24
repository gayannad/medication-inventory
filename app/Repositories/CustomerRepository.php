<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    private Customer $customer;

    /**
     * Create a new class instance.
     */
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }
}
