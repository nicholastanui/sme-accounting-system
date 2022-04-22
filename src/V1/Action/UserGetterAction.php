<?php

namespace App\V1\Action;
use App\V1\Main\UserGetter;
use App\V1\Data\UserData;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserGetterAction
{
    private UserGetter $userGetter;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(UserGetter $repository)
    {
      //  $this->responder = $responder;
       $this->userGetter = $repository;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The routing arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $userId = (int)$args['id'];

        // Invoke the domain (service class)
        $user = $this->userGetter->getUser($userId);

        // Transform result
      return $this->transform($response, $user);
      //return $campaign;
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param UserData $user The user
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, UserData $user): ResponseInterface
    {
        // Turn that object into a structured array
        $data = [
            'id' => $user->id,
            'msisdn' => $user->msisdn,
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'company_id' => $user->companyId,
            'role' => $user->role,
            'active' => $user->active,

        ];

        // Turn all of that into a JSON string and put it into the response body
        return $this->withJson($response,   [
            'header'=>['responseCode'=>'200','responseMessage'=>'User fetched successfully!'],
            'body'=>
       (object) $data
        
      ]);
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
