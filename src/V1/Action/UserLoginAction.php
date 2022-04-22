<?php

namespace App\V1\Action;
use App\V1\Main\UserAuthenticator;
use App\V1\Data\UserData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\V1\Interfaces\SecretKeyInterface;
use Firebase\JWT\JWT;
/**
 * Action.
 */
final class UserLoginAction implements SecretKeyInterface
{
    private UserAuthenticator $authenticator;

  //  private Responder $responder;

    /**
     * The constructor.
     *
     * @param CampaignReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(UserAuthenticator $repository)
    {
      //  $this->responder = $responder;
       $this->authenticator = $repository;
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
        $data = (array)$request->getParsedBody();

        // Invoke the domain (service class)
        $auth = $this->authenticator->loginUser($data);

        if($auth){
          $responseMessage = $this->generateToken($data['msisdn']);


          $result =(object)
            [
              'header'=>['responseCode'=>'200','responseMessage'=>'Login Success!'],
              'body'=>[
                'token' => $responseMessage
              ]


          ];

          // Build the HTTP response
          $response->getBody()->write((string)json_encode($result));

          return $response
              ->withHeader('Content-Type', 'application/json')
              ->withStatus(201);


        }else{
          $result = (object)
            [
              'header'=>['responseCode'=>'402','responseMessage'=>'Login Failed!'],
              'body'=>[
                'data' => "Wrong username/password"
            ]

          ];

          // Build the HTTP response
          $response->getBody()->write((string)json_encode($result));

          return $response
              ->withHeader('Content-Type', 'application/json')
              ->withStatus(402);


        }
        // Transform result
    //  return $this->transform($response, $campaign);

    }
private static function generateToken($msisdn){
  $now = time();
  $future = strtotime('+1 hour',$now);
  $secretKey = self::JWT_SECRET_KEY;
  $payload = [
   "jti"=>$msisdn,
   "iat"=>$now,
   "exp"=>$future
  ];

  return JWT::encode($payload,$secretKey,"HS256");

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
