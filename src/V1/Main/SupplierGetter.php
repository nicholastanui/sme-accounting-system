<?php

namespace App\V1\Main;
use App\V1\Data\SupplierData;
use App\V1\Repository\SKRepository;


/**
 * Service.
 */
final class SupplierGetter
{
    /**
     * @var SKRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param SKRepository $repository The repository
     */
    public function __construct(SKRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new campaign.
     *
     * @param array $data The form data
     *
     * @return int The campaign ID
     */
    public function getSupplier($companyId):SupplierData
    {

        // get company
        $company = $this->repository->getSupplierById($companyId);

        return $company;
    }


}
