<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    public function loginAction(Request $request)
    {
        $data = json_decode($request->getContent());

        $userService = $this->get('jmlshopping.user');
        $authenticationResult = $userService->authenticate($data->username, $data->password);

        if (!empty($authenticationResult['token'])) {
            $response = new JsonResponse($authenticationResult);
        } else {
            $response = new JsonResponse('Bad credentials', Response::HTTP_UNAUTHORIZED);
        }

        return $response;
    }
}
