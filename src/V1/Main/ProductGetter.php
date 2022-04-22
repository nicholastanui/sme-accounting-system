<?php

namespace App\V1\Main;
use App\V1\Data\ProductData;
use App\V1\Repository\SKRepository;


/**
 * Service.
 */
final class ProductGetter
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
    public function getProduct($periodId):ProductData
    {

        // get company
        $period = $this->repository->getProductById($periodId);

        return $period;
    }


}
