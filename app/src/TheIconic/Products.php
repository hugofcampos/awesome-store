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

    public function __construct(GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    public function get()
    {
        $response = $this->client->request('GET', self::SERVICE);

        $content = json_decode($response->getBody());

        return $content->_embedded->product;
    }
}
