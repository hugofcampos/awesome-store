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
    public function get(string $query)
    {
        $response = $this->client->request('GET', self::SERVICE, [
            'query' => ['q' => $query]
        ]);

        $content = json_decode($response->getBody());

        return $content->_embedded->product;
    }
}
