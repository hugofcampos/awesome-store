<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\TheIconic;

class ProductController extends Controller
{
    const PAGE_SIZE = 10;

    /**
     * @var TheIconic\Products
     */
    private $service;

    /**
     * @var TheIconic\Paginator
     */
    private $paginator;

    /**
     * @param TheIconic\Products  $service
     * @param TheIconic\Paginator $paginator
     */
    public function __construct(TheIconic\Products $service, TheIconic\Paginator $paginator)
    {
        $this->service = $service;
        $this->paginator = $paginator;
    }

    /**
     * @param  Request $request
     * @return Response
     */
    public function list(Request $request) : Response
    {
        $query = $request->query->get('q', '');
        $page = $request->query->get('page', 1);

        $this->paginator->paginate($query, $page, self::PAGE_SIZE);

        return $this->render(
            'product/list.html.twig',
            [
                'query' => $query,
                'paginator' => $this->paginator,
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
