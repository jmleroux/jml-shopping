<?php

namespace Jmleroux\JmlShopping\Api\Tests\Integration\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CategoryControllerTest extends WebTestCase
{
    public function testAuthenticationDenied()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/api/categories');
        Assert::assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }

    public function testListCategories()
    {
        $this->client = static::createClient();
        $this->logIn();
        $this->client->request('GET', '/api/categories');
        Assert::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $json = json_decode($this->client->getResponse()->getContent(), true);
        Assert::assertCount(10, $json);
        Assert::assertSame($json[0], ['id' => 'cid6', 'name' => 'Boissons']);
        Assert::assertSame($json[9], ['id' => 'cid10', 'name' => 'Surgelés']);
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
