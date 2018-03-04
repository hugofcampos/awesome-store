<?php

namespace App\Tests\TheIconic;

use PHPUnit\Framework\TestCase;
use App\TheIconic\Products;

class ProductsTest extends TestCase
{
    public function testSearchProducts()
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
            ->with(
                'GET',
                'https://eve.theiconic.com.au/catalog/products',
                ['query' => ['q' => 'some-text', 'page' => 1, 'page_size' => 10]])
            ->will($this->returnValue($response));

        $products = new Products($guzzle);
        $result = $products->search('some-text', 1, 10);

        $this->assertEquals(json_decode($body), $result);
    }

    public function testGetProductBySku()
    {
        $body = json_encode(['example-product']);

        $response = $this->createMock(\GuzzleHttp\Psr7\Response::class);
        $response
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($body));

        $guzzle = $this->createMock(\GuzzleHttp\Client::class);
        $guzzle
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'https://eve.theiconic.com.au/catalog/products/some-sku')
            ->will($this->returnValue($response));

        $products = new Products($guzzle);
        $result = $products->get('some-sku');

        $this->assertEquals(['example-product'], $result);
    }

    /**
     * @expectedException App\TheIconic\ProductNotFoundException
     */
    public function testGetProductBySkuNotFound()
    {
        $body = json_encode(['example-product']);

        $response = $this->createMock(\GuzzleHttp\Psr7\Response::class);
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(404));
        $response
            ->expects($this->never())
            ->method('getBody');

        $exception = $this->createMock(\GuzzleHttp\Exception\ClientException::class);
        $exception
            ->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $guzzle = $this->createMock(\GuzzleHttp\Client::class);
        $guzzle
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'https://eve.theiconic.com.au/catalog/products/some-sku')
            ->will($this->throwException($exception));

        $products = new Products($guzzle);
        $products->get('some-sku');
    }
}
