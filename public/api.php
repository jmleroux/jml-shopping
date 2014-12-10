<?php
use Api\Application;
use Api\CategoryService;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/../config/global.php';

$app = new Api\Application($config);

$app->post(
    '/login',
    function (Request $request, Application $app) {
        $post = json_decode($request->getContent());
        $username = strip_tags($post->username);
        /** @var  \Api\UserService $userService */
        $userService = $app['user_service'];
        $authenticationResult = $userService->authenticate($username, $post->password);
        if (!$authenticationResult['token']) {
            return $app->getUnauthorizedResponse('Invalid informations');
        }
        return $app->json($authenticationResult);
    }
);

$app->get(
    '/product',
    function (Application $app) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        /** @var  \Api\ProductService $productService */
        $productService = $app['product_service'];
        $rows = $productService->getAll();

        return $app->json($rows);
    }
);

$app->get(
    '/product/{id}',
    function (Application $app, $id) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        /** @var  \Api\ProductService $service */
        $service = $app['product_service'];
        $product = $service->getProduct($id);

        return $app->json($service->getHydrator()->extract($product));
    }
);

$app->post(
    '/product',
    function (Request $request, Api\Application $app) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        $post = json_decode($request->getContent(), true);
        /** @var  \Api\ProductService $productService */
        $productService = $app['product_service'];
        $product = new \Api\Entity\Product();
        $productService->getHydrator()->hydrate($post, $product);
        if ($product->getId()) {
            $productService->update($product);
        } else {
            $productService->create($product);
        }
        $rows = $productService->getAll();

        return $app->json($rows);
    }
);

$app->delete(
    '/product/{id}',
    function (Api\Application $app, Request $request, $id) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        /** @var  \Api\ProductService $productService */
        $productService = $app['product_service'];
        $productService->remove($id);
        $rows = $productService->getAll();

        return $app->json($rows);
    }
);

$app->delete(
    '/product',
    function (Api\Application $app, Request $request) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        /** @var  \Api\ProductService $productService */
        $productService = $app['product_service'];
        $productService->removeAll();
        $rows = $productService->getAll();

        return $app->json($rows);
    }
);

$app->get(
    '/category',
    function (Application $app) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        /** @var  \Api\CategoryService $categoryService */
        $categoryService = $app['category_service'];
        $rows = $categoryService->getAll();

        return $app->json($rows);
    }
);

$app->get(
    '/category/{id}',
    function (Application $app, $id) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        /** @var  \Api\CategoryService $service */
        $service = $app['category_service'];
        $category = $service->getCategory($id);

        return $app->json($category->extract());
    }
);

$app->post(
    '/category',
    function (Application $app, Request $request) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        if (!$request->headers->get('x-token')) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };

        /** @var  CategoryService $service */
        $service = $app['category_service'];

        $post = json_decode($request->getContent());
        $category = $service->parseRequest($post);

        if ($category->getId()) {
            $service->update($category);
        } else {
            $service->create($category);
        }
        $rows = $service->getAll();

        return $app->json($rows);
    }
);

$app->delete(
    '/category/{id}',
    function (Application $app, Request $request, $id) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        /** @var  \Api\CategoryService $service */
        $service = $app['category_service'];
        $service->remove($id);
        $rows = $service->getAll();

        return $app->json($rows);
    }
);

$app->delete(
    '/category',
    function (Application $app) {
        if (!$app->authenticate()) {
            return $app->getUnauthorizedResponse('Please sign in.');
        };
        /** @var  \Api\CategoryService $categoryService */
        $categoryService = $app['category_service'];
        $rows = $categoryService->getAll();

        return $app->json($rows);
    }
);

$app->run();
