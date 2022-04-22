<?php

namespace App\V1\Action;
use App\V1\Repository\AllUsersGetterRepository;
use App\V1\Data\UserData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AllUsersGetterAction
{
    private AllUsersGetterRepository $usersReader;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AllUsersGetterRepository $repository)
    {
      //  $this->responder = $responder;
       $this->usersReader = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findUsers method
        $users = $this->usersReader->findUsers();

        return $this->transform($response, $users);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param CampaignData $user The user
     *
     * @return ResponseInterface The response
     */
     private function transform(ResponseInterface $response, array $users): ResponseInterface
     {
             $userList = [];

             foreach ($users as $user) {
                 $userList[] = [

                'id' => $user->id,
                'msisdn' => $user->msisdn,
                'first_name' => $user->firstName,
                'last_name' => $user->lastName,
                'company_id' => $user->companyId,
                'role' => $user->role,
                'active' => $user->active,

                ];
            }
        return $this->withJson(
            $response,
            [
              'header'=>['responseCode'=>'200','responseMessage'=>'Users fetched successfully'],
              'body'=>[
        'data' => $userList,
          ]
        ]
        );
    }
    public function withJson(
        ResponseInterface $response,
        $data = null,
        int $options = 0
    ): ResponseInterface {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write((string)json_encode($data, $options));

        return $response;
    }
}
