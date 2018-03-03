<?php

namespace App\TheIconic;

class Paginator
{
    /**
     * @var Products
     */
    private $product;

    /**
     * @var object
     */
    private $response;

    /**
     * @param Products $products
     */
    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
     * @param  string $query
     * @param  int    $page
     * @param  int    $pageSize
     * @return this
     */
    public function paginate(string $query, int $page, int $pageSize)
    {
        $this->response = $this->products->search($query, $page, $pageSize);

        return $this;
    }

    private function getResponse()
    {
        if (!$this->response) {
            throw new ProductNotFoundException;
        }
        return $this->response;
    }

    /**
     * @return int
     */
    public function getContent()
    {
        return $this->getResponse()->_embedded->product;
    }

    /**
     * @return int
     */
    public function getPageCount()
    {
        return $this->getResponse()->page_count;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->getResponse()->page_size;
    }

    /**
     * @return int
     */
    public function getItems()
    {
        return $this->getResponse()->total_items;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->getResponse()->page;
    }
}
