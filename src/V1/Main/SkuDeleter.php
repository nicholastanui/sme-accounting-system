<?php

namespace App\V1\Main;

use App\V1\Repository\DeleteRepository;

/**
 * Service.
 */
final class SkuDeleter
{
    private DeleteRepository $repository;

    /**
     * The constructor.
     *
     * @param DeleteRepository $repository The repository
     */
    public function __construct(DeleteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete campaign.
     *
     * @param int $campaignId The campaign id
     *
     * @return void
     */
    public function deleteSku($campaignId): int
    {
        // Input validation
        // ...

      return  $this->repository->deleteSku($campaignId);
    }
}
