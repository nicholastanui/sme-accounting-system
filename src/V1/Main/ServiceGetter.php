<?php

namespace App\V1\Main;
use App\V1\Data\ServiceData;
use App\V1\Repository\SKRepository;


/**
 * Service.
 */
final class ServiceGetter
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
     * get a acc period by id.
     *
     * @param array $data The form data
     *
     * @return period by id
     */
    public function getService($periodId):ServiceData
    {

        // get company
        $period = $this->repository->getServiceById($periodId);

        return $period;
    }


}
