<?php

namespace App\Tests\TheIconic;

use PHPUnit\Framework\TestCase;
use App\TheIconic\Products;

class ProductsTest extends TestCase
{
    public function testGetProductList()
    {
        $body = json_encode(['_embedded'=>['product'=>['example-product']]]);

        $response = $this->createMock(\GuzzleHttp\Psr7\Response::class);
        $response
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($body));

        $guzzle = $this->createMock(\GuzzleHttp\Client::class);
        $guzzle
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'https://eve.theiconic.com.au/catalog/products', ['query' => ['q' => 'some-text']])
            ->will($this->returnValue($response));

        $products = new Products($guzzle);
        $result = $products->get('some-text');

        $this->assertEquals(['example-product'], $result);
    }
}
