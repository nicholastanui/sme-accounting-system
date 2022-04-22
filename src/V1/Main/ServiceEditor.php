<?php
namespace App\V1\Main;
use App\V1\Repository\EditRepository;
use App\V1\Exception\ValidationException;


class ServiceEditor
{

    protected $period;
    protected $customResponse;

    public function __construct(EditRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validateService(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library
        if (empty($data['id'])) {
            $errors['id'] = 'Input required';
        }
        if (empty($data['name'])) {
            $errors['name'] = 'Input required';
        }

        if (empty($data['price'])) {
            $errors['price'] = 'Input required';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
    public function editService(array $data)
    {


      // Input validation
      $this->validateService($data);

      $insertId=$this->repository->editService($data);

      return $insertId;
    }



}
