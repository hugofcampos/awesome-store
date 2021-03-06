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
     * @param  int    $page
     * @param  int    $pageSize
     * @return Paginator
     */
    public function search(string $query, int $page, int $pageSize)
    {
        $response = $this->client->request('GET', self::SERVICE, [
            'query' => [
                'q' => $query,
                'page' => $page,
                'page_size' => $pageSize,
            ]
        ]);

        $content = json_decode($response->getBody());

        return $content;
    }

    /**
     * @param  string $sku
     * @return array
     * @throws ProductNotFoundException
     */
    public function get(string $sku)
    {
        try {
            $response = $this->client->request('GET', sprintf('%s/%s', self::SERVICE, $sku));
        } catch (GuzzleHttp\Exception\ClientException $exception) {
            if (404 == $exception->getResponse()->getStatusCode()) {
                throw new ProductNotFoundException;
            }
            throw $exception;
        }

        $content = json_decode($response->getBody());

        return $content;
    }
}
