<?php

namespace Jmleroux\JmlShopping\Api\Tests\Integration\Controller;

use Jmleroux\JmlShopping\Api\Tests\Integration\Utils;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class CategoryControllerTest extends WebTestCase
{
    public function testAuthenticationDenied()
    {
        $client = static::createClient();
        $client->request('GET', '/categories');
        Assert::assertEquals($client->getResponse()->getStatusCode(), 401);
    }

    public function testListCategories()
    {
        $client = static::createClient();
        $client->request('GET', '/categories', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN]);
        Assert::assertEquals($client->getResponse()->getStatusCode(), 200);

        $json = json_decode($client->getResponse()->getContent(), true);
        Assert::assertCount(10, $json);
        Assert::assertSame($json[0], ['id' => 'cid6', 'name' => 'Boissons']);
        Assert::assertSame($json[9], ['id' => 'cid10', 'name' => 'Surgelés']);
    }
}
