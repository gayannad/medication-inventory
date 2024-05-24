<?php

namespace App\Repositories;

use App\Interfaces\MedicationRepositoryInterface;
use App\Models\Medication;

class MedicationRepository extends BaseRepository implements MedicationRepositoryInterface
{
    private Medication $medication;

    public function __construct(Medication $medication)
    {
        parent::__construct($medication);
    }
}
