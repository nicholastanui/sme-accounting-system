<?php

namespace App\V1\Main;
use App\V1\Data\CustomerData;
use App\V1\Repository\SKRepository;


/**
 * Service.
 */
final class CustomerGetter
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
    public function getCustomer($userId):CustomerData
    {

        // get user
        $user = $this->repository->getCustomerbyId($userId);

        return $user;
    }


}
