<?php
namespace App\V1\Main;
use App\V1\Repository\SKRepository;
use App\V1\Exception\ValidationException;


class SkuCreator
{

    protected $period;
    protected $customResponse;

    public function __construct(SKRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateSku(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['name'])) {
            $errors['name'] = 'Input required';
        }



        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function createSku(array $data)
    {
      // Input validation
      $this->validateSku($data);

      $insertId=$this->repository->createSku($data);

      return $insertId;
    }



}
