<?php

namespace Jmleroux\JmlShopping\Api\Tests\Integration\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\ProductSelection;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\ProductRepository;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\ProductSelectionRepository;
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
class ProductSelectionControllerTest extends WebTestCase
{
    /** @var KernelBrowser */
    public $client;

    public function testAuthenticationDenied()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/api/product-selection');
        Assert::assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }

    public function testListProductSelection()
    {
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('GET', '/api/product-selection');
        Assert::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $json = json_decode($this->client->getResponse()->getContent(), true);

        Assert::assertCount(4, $json);
        Assert::assertSame(
            ['id' => 'psid1', 'name' => 'Lait', 'category_id' => 'cid1', 'category' => 'Frais'],
            $json[0]
        );
        Assert::assertSame(
            [
                'id' => 'psid3',
                'name' => 'Encre noire',
                'category_id' => 'cid2',
                'category' => 'Scolaire',
            ],
            $json[3]
        );
    }

    public function testDeleteProductSelection()
    {
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('DELETE', '/api/product-selection/psid2');

        $json = $this->client->getResponse()->getContent();
        Assert::assertEquals(1, $json);
    }

    public function testCreateProductSelection()
    {
        $invalidData = json_encode([
            'id' => 'psid100',
            'categoryId' => '',
        ]);
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('POST', '/api/product-selection', [], [], [], $invalidData);

        Assert::assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $postData = json_encode([
            'id' => 'psid100',
            'name' => 'testproduct',
            'category_id' => 'cid1',
        ]);
        static::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('POST', '/api/product-selection', [], [], [], $postData);

        Assert::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/product-selection');
        $json = json_decode($this->client->getResponse()->getContent(), true);
        Assert::assertCount(5, $json);

        /** @var ProductSelection $createdProduct */
        $createdProduct = static::$container->get(ProductSelectionRepository::class)->getProduct('psid100');
        Assert::assertNotNull($createdProduct);
        Assert::assertEquals('testproduct', $createdProduct['name']);
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
