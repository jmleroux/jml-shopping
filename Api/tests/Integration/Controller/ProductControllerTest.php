<?php

namespace Jmleroux\JmlShopping\Api\Tests\Integration\Controller;

use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class ProductControllerTest extends WebTestCase
{
    public function testListCategories()
    {
        $client = static::createClient();
        $client->request('GET', '/products');

        $json = json_decode($client->getResponse()->getContent(), true);
        Assert::assertCount(4, $json);
        Assert::assertSame($json[0],
            ['id' => 'pid1', 'name' => 'product1', 'quantity' => 10, 'category_id' => 'cid1', 'category' => 'Frais']);
        Assert::assertSame($json[3],
            ['id' => 'pid4', 'name' => 'product4', 'quantity' => 10, 'category_id' => 'cid2', 'category' => 'Scolaire']);
    }
}
