<?php

namespace Jmleroux\JmlShopping\Api\Tests\Integration\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\ProductRepository;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class ProductControllerTest extends WebTestCase
{
    /** @var KernelBrowser */
    public $client;

    public function testAuthenticationDenied()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/api/products');
        Assert::assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }

    public function testListProducts()
    {
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('GET', '/api/products');
        Assert::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $json = json_decode($this->client->getResponse()->getContent(), true);

        Assert::assertCount(4, $json);
        Assert::assertSame($json[0],
            ['id' => 'pid1', 'name' => 'product1', 'quantity' => 10, 'category_id' => 'cid1', 'category' => 'Frais']);
        Assert::assertSame($json[3],
            [
                'id' => 'pid4',
                'name' => 'product4',
                'quantity' => 10,
                'category_id' => 'cid2',
                'category' => 'Scolaire',
            ]);
    }

    public function testDeleteProduct()
    {
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('DELETE', '/api/product/pid2');

        $json = $this->client->getResponse()->getContent();
        Assert::assertEquals(1, $json);
    }

    public function testTruncate()
    {
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('DELETE', '/api/products');

        Assert::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        static::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('GET', '/api/products');

        $json = json_decode($this->client->getResponse()->getContent(), true);
        Assert::assertCount(0, $json);
    }

    public function testCreateProduct()
    {
        $invalidData = json_encode([
            'id' => 'pid100',
            'categoryId' => 'cid1',
            'quantity' => 50,
        ]);
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('POST', '/api/product', [], [], [], $invalidData);

        Assert::assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $invalidData = json_encode([
            'id' => 'pid1',
            'name' => 'product1',
            'categoryId' => 'cid1',
            'quantity' => 50,
        ]);
        static::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('POST', '/api/product', [], [], [], $invalidData);

        Assert::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $this->client->getResponse()->getStatusCode());

        $postData = json_encode([
            'id' => 'pid100',
            'name' => 'testproduct',
            'category_id' => 'cid1',
            'quantity' => 50,
        ]);
        static::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('POST', '/api/product', [], [], [], $postData);

        Assert::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/products');
        $json = json_decode($this->client->getResponse()->getContent(), true);
        Assert::assertCount(5, $json);

        $productExists = static::$container->get(ProductRepository::class)->productExists('pid100');
        Assert::assertTrue($productExists);
    }

    public function testUpdateProductQuantity()
    {
        $postData = json_encode([
            'id' => 'pid1',
            'name' => 'product1',
            'category_id' => 'cid2',
            'quantity' => 60,
        ]);
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('POST', '/api/product', [], [], [], $postData);

        Assert::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/products');
        $json = json_decode($this->client->getResponse()->getContent(), true);
        Assert::assertCount(4, $json);

        /** @var Product $product */
        $product = static::$container->get(ProductRepository::class)->getProduct('pid1');
        Assert::assertNotNull($product);
        Assert::assertEquals(60, $product['quantity']);
    }

    public function testUpdateProductCategory()
    {
        $postData = json_encode([
            'id' => 'pid1',
            'name' => 'product1',
            'category_id' => 'cid1',
            'quantity' => 50,
        ]);
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('POST', '/api/product', [], [], [], $postData);

        Assert::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/products');
        $json = json_decode($this->client->getResponse()->getContent(), true);
        Assert::assertCount(4, $json);

        /** @var Product $product */
        $product = static::$container->get(ProductRepository::class)->getProduct('pid1');
        Assert::assertNotNull($product);
        Assert::assertEquals('cid1', $product['category_id']);
    }

    public function testUpdateProductName()
    {
        $postData = json_encode([
            'id' => 'pid1',
            'name' => 'testproduct',
            'category_id' => 'cid2',
            'quantity' => 50,
        ]);
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('POST', '/api/product', [], [], [], $postData);

        Assert::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    private function logIn()
    {
        $session = self::$container->get('session');
        $user = static::$container->get(UserRepository::class)->findByUsername('jmleroux.pro@gmail.com');

        $firewallName = 'main';
        // if you don't define multiple connected firewalls, the context defaults to the firewall name
        // See https://symfony.com/doc/current/reference/configuration/security.html#firewall-context
        $firewallContext = 'main';

        $token = new PostAuthenticationGuardToken($user, $firewallName, $user->getRoles());
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
