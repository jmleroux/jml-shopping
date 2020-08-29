<?php
declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\Tests\Integration\Controller;

use Jmleroux\JmlShopping\Api\Tests\Integration\Utils;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class TokenControllerTest extends WebTestCase
{
    public function testLoginKo()
    {
        $loginData = json_encode([
            'username' => 'admin',
            'password' => 'invalid_password',
        ]);
        $client = static::createClient();
        $client->request('POST', '/login', [], [], [], $loginData);
        Assert::assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testLoginOk()
    {
        $loginData = json_encode([
            'username' => 'admin',
            'password' => 'foobar',
        ]);
        $client = static::createClient();
        $client->request('POST', '/login', [], [], [], $loginData);
        Assert::assertEquals(200, $client->getResponse()->getStatusCode());

        $response = json_decode($client->getResponse()->getContent(), true);

        Assert::assertEquals(Utils::VALID_USER, $response['username']);
        Assert::assertRegExp('/admin-\+-.{272}/', $response['token']);
    }
}
