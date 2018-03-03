<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\TheIconic;

class ProductController extends Controller
{
    /**
     * @var TheIconic\Products
     */
    private $service;

    /**
     * @param TheIconic\Products $service
     */
    public function __construct(TheIconic\Products $service)
    {
        $this->service = $service;
    }

    /**
     * @param  Request $request
     * @return Response
     */
    public function list(Request $request) : Response
    {
        $query = $request->query->get('q', '');

        $products = $this->service->search($query);

        return $this->render(
            'product/list.html.twig',
            [
                'query' => $query,
                'products' => $products,
            ]
        );
    }

    /**
     * @param  string $sku
     * @return Response
     */
    public function details(string $sku)
    {
        $product = $this->findProduct($sku);

        return $this->render(
            'product/details.html.twig',
            [
                'product' => $product
            ]
        );
    }

    /**
     * @param  string $sku
     * @return array
     */
    protected function findProduct(string $sku)
    {
        try {
            return $this->service->get($sku);
        } catch(TheIconic\ProductNotFoundException $exception) {
            throw $this->createNotFoundException();
        }
    }
}
