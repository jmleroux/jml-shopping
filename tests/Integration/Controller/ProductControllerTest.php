<?php

namespace Jmleroux\JmlShopping\Api\Tests\Integration\Controller;

use Jmleroux\JmlShopping\Api\Tests\Integration\Utils;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author JM Leroux <jmleroux.pro@gmail.com>
 */
class ProductControllerTest extends WebTestCase
{
    public function testAuthenticationDenied()
    {
        $client = static::createClient();
        $client->request('GET', '/products');
        Assert::assertEquals($client->getResponse()->getStatusCode(), 401);
    }

    public function testListProducts()
    {
        $client = static::createClient();
        $client->request('GET', '/products', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN]);
        Assert::assertEquals($client->getResponse()->getStatusCode(), 200);

        $json = json_decode($client->getResponse()->getContent(), true);

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

    public function testViewProduct()
    {
        $client = static::createClient();
        $client->request('GET', '/product/pid1', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN]);
        Assert::assertEquals($client->getResponse()->getStatusCode(), 200);

        $json = json_decode($client->getResponse()->getContent(), true);
        Assert::assertSame($json,
            [
                'id' => 'pid1',
                'name' => 'product1',
                'quantity' => 10,
                'category_id' => 'cid1',
                'category' => [
                    'id' => 'cid1',
                    'name' => 'Frais',
                ],
            ]);
    }

    public function testDeleteProduct()
    {
        $client = static::createClient();
        $client->request('DELETE', '/product/pid2', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN]);

        $json = $client->getResponse()->getContent();
        Assert::assertEquals($json, 1);
    }

    public function testTruncate()
    {
        $client = static::createClient();
        $client->request('DELETE', '/products', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN]);

        Assert::assertEquals($client->getResponse()->getStatusCode(), 200);

        $client = static::createClient();
        $client->request('GET', '/products', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN]);

        $json = json_decode($client->getResponse()->getContent(), true);
        Assert::assertCount(0, $json);
    }

    public function testCreateProduct()
    {
        $invalidData = json_encode([
            'id' => 'pid100',
            'categoryId' => 'cid1',
            'quantity' => 50,
        ]);
        $client = static::createClient();
        $client->request('POST', '/product', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN], $invalidData);

        Assert::assertEquals($client->getResponse()->getStatusCode(), 422);

        $invalidData = json_encode([
            'id' => 'pid1',
            'name' => 'product1',
            'categoryId' => 'cid1',
            'quantity' => 50,
        ]);
        $client = static::createClient();
        $client->request('POST', '/product', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN], $invalidData);

        Assert::assertEquals($client->getResponse()->getStatusCode(), 226);

        $postData = json_encode([
            'id' => 'pid100',
            'name' => 'testproduct',
            'categoryId' => 'cid1',
            'quantity' => 50,
        ]);
        $client = static::createClient();
        $client->request('POST', '/product', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN], $postData);

        Assert::assertEquals($client->getResponse()->getStatusCode(), 201);

        $client->request('GET', '/products');
        $json = json_decode($client->getResponse()->getContent(), true);
        Assert::assertCount(5, $json);

        $client->request('GET', '/product/pid100');
        $json = json_decode($client->getResponse()->getContent(), true);
        Assert::assertSame($json,
            [
                'id' => 'pid100',
                'name' => 'testproduct',
                'quantity' => 50,
                'category_id' => 'cid1',
                'category' => [
                    'id' => 'cid1',
                    'name' => 'Frais',
                ],
            ]);
    }

    public function testUpdateProduct()
    {
        $invalidData = json_encode([
            'categoryId' => 'cid1',
            'quantity' => 50,
        ]);
        $client = static::createClient();
        $client->request('PUT', '/product/pid1', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN], $invalidData);

        Assert::assertEquals($client->getResponse()->getStatusCode(), 422);

        $postData = json_encode([
            'id' => 'pid1',
            'name' => 'testproduct',
            'categoryId' => 'cid2',
            'quantity' => 50,
        ]);
        $client = static::createClient();
        $client->request('PUT', '/product/pid1', [], [], ['HTTP_X-AUTH-TOKEN' => Utils::VALID_TOKEN], $postData);

        Assert::assertEquals($client->getResponse()->getStatusCode(), 200);

        $client->request('GET', '/products');
        $json = json_decode($client->getResponse()->getContent(), true);
        Assert::assertCount(4, $json);

        $client->request('GET', '/product/pid1');
        $json = json_decode($client->getResponse()->getContent(), true);
        Assert::assertSame($json,
            [
                'id' => 'pid1',
                'name' => 'testproduct',
                'quantity' => 50,
                'category_id' => 'cid2',
                'category' => [
                    'id' => 'cid2',
                    'name' => 'Scolaire',
                ],
            ]);
    }
}
