<?php
namespace App\V1\Main;
use App\V1\Repository\SKRepository;
use App\V1\Exception\ValidationException;


class ServiceCreator
{

    protected $period;
    protected $customResponse;

    public function __construct(SKRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateService(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['name'])) {
            $errors['name'] = 'Input required';
        }

        if (empty($data['price'])) {
            $errors['price'] = 'Input required';
        }
        if (empty($data['company'])) {
              $errors['company'] = 'Input required';
           }
        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function createService(array $data)
    {
      // Input validation
      $this->validateService($data);

      $insertId=$this->repository->createService($data);

      return $insertId;
    }



}
