<?php

namespace App\V1\Main;

use App\V1\Repository\DeleteRepository;

/**
 * Service.
 */
final class CompanyDeleter
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
    public function deleteCompany($campaignId): int
    {
        // Input validation
        // ...

      return  $this->repository->deleteCompany($campaignId);
    }
}
