<?php

namespace App\TheIconic;

use GuzzleHttp;

class Products
{
    const SERVICE = 'https://eve.theiconic.com.au/catalog/products';

    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param GuzzleHttp\Client $client
     */
    public function __construct(GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param  string $query
     * @return array
     */
    public function search(string $query)
    {
        $response = $this->client->request('GET', self::SERVICE, [
            'query' => ['q' => $query]
        ]);

        $content = json_decode($response->getBody());

        return $content->_embedded->product;
    }

    /**
     * @param  string $sku
     * @return array
     * @throws ProductNotFoundException
     */
    public function get(string $sku)
    {
        $response = $this->client->request('GET', sprintf('%s/%s', self::SERVICE, $sku));

        if (404 == $response->getStatusCode()) {
            throw new ProductNotFoundException;
        }

        $content = json_decode($response->getBody());

        return $content;
    }
}
