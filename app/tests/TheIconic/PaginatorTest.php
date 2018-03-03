<?php

namespace App\Tests\TheIconic;

use PHPUnit\Framework\TestCase;
use App\TheIconic\Paginator;

class PaginatorTest extends TestCase
{
    /**
     * @expectedException App\TheIconic\ProductNotFoundException
     */
    public function testPaginateNoResponse()
    {
        $products = $this->createMock(\App\TheIconic\Products::class);

        $paginator = new Paginator($products);

        $paginator->getContent();
    }

    public function testPaginate()
    {
        $body = json_decode(json_encode(
            [
                '_embedded'=>['product'=>['example-product']],
                'page_count' => 10,
                'page_size' => 10,
                'total_items' => 95,
                'page' => 1,
            ]
        ));

        $products = $this->createMock(\App\TheIconic\Products::class);
        $products
            ->expects($this->once())
            ->method('search')
            ->with('', 1, 10)
            ->will($this->returnValue($body));

        $paginator = new Paginator($products);

        $paginator->paginate('', 1, 10);

        $this->assertEquals($paginator->getContent(), ['example-product']);
        $this->assertEquals($paginator->getPageCount(), 10);
        $this->assertEquals($paginator->getPageSize(), 10);
        $this->assertEquals($paginator->getItems(), 95);
        $this->assertEquals($paginator->getPage(), 1);
    }
}
