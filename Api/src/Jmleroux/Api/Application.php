<?php

namespace Jmleroux\Api;

use Jmleroux\Core\CategoryService;
use Jmleroux\Core\ProductService;
use Jmleroux\Core\UserService;
use Silex;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class Application extends Silex\Application
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $values = [])
    {
        parent::__construct($values['app']);

        $this->config = $values;

        $localConfigFile = $this['app.root'] . '/config/local.php';
        if (file_exists($localConfigFile)) {
            $localConfig = include $localConfigFile;
            foreach ($localConfig['app'] as $key => $value) {
                $this[$key] = $value;
            }
        }

        $this->registerProviders();
        $this->registerServices();
    }

    public function registerProviders()
    {
        $this->register(
            new Silex\Provider\DoctrineServiceProvider(),
            [
                'db.options' => $this->config['db.options'],
            ]
        );
        $this->register(
            new Silex\Provider\MonologServiceProvider(),
            [
                'monolog.logfile' => $this['app.root'] . '/var/logs/application.log',
            ]
        );
    }

    public function registerServices()
    {
        $this['product_service'] = function () {
            return new ProductService($this['db'], $this['category_service']);
        };

        $this['user_service'] = function () {
            return new UserService($this['db'], $this['seed']);
        };

        $this['category_service'] = function () {
            return new CategoryService($this['db']);
        };
    }

    public function getUnauthorizedResponse($message = '')
    {
        $response = new Response();
        $response->setStatusCode(401, $message);

        return $response;
    }

    public function authenticate()
    {
        /** @var RequestStack $requestStack */
        $requestStack = $this['request_stack'];
        $request = $requestStack->getCurrentRequest();
        $token = $request->headers->get('x-token');
        if (!$token) {
            return false;
        };
        /** @var  UserService $userService */
        $userService = $this['user_service'];

        return $userService->tokenIsValid($token);
    }
}
