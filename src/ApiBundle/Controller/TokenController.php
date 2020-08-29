<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Security\PasswordAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    public function loginAction(Request $request, PasswordAuthenticator $passwordAuthenticator)
    {
        $data = json_decode($request->getContent());

        $authenticationResult = $passwordAuthenticator->authenticate($data->username, $data->password);

        if (!empty($authenticationResult['token'])) {
            $response = new JsonResponse($authenticationResult);
        } else {
            $response = new JsonResponse('Bad credentials', Response::HTTP_UNAUTHORIZED);
        }

        return $response;
    }
}
