<?php
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Selective\BasePath\BasePathMiddleware;
use App\V1\Support\HttpsMiddleware;

use Selective\BasePath\BasePathDetector;
return function (App $app) {

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();
    // Redirect HTTP traffic to HTTPS
  //  $app->add(HttpsMiddleware::class);
  //Autodetect project directory name
   $basePath = (new BasePathDetector($_SERVER))->getBasePath();
      // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();
    $app->add(
      new \Tuupola\Middleware\JwtAuthentication([
    //  "path" => "/auth",
        "ignore"=>[$basePath."/auth/login",$basePath."/auth/createuser"],
        "secure" => false,
        "secret"=>\App\V1\Interfaces\SecretKeyInterface::JWT_SECRET_KEY,
        "error"=>function($response,$arguments)
          {

              // $data["success"] = false;
              // $data["response"]=$arguments["message"];
              // $data["status_code"]= "401";
              // return $response->withHeader("Content-type","application/json")
              //     ->getBody()->write(json_encode($data,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ));

                  $result = (object)
                    [
                      'header'=>['responseCode'=>'401','responseMessage'=>$arguments["message"]],
                      'body'=>[
                        'data' => $arguments["message"]
                    ]

                  ];

                  return $response->withHeader("Content-type","application/json")
                      ->getBody()->write(json_encode($result,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ));


          }
      ])
  );
    $app->add(BasePathMiddleware::class);
    // Catch exceptions and errors
    $app->add(ErrorMiddleware::class);
};
