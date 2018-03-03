<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\TheIconic;

class ProductController extends Controller
{
    /**
     * @param  Request            $request
     * @param  TheIconic\Products $service
     * @return Response
     */
    public function list(Request $request, TheIconic\Products $service) : Response
    {
        $query = $request->query->get('q', '');

        $products = $service->get($query);

        return $this->render(
            'product/list.html.twig',
            [
                'query' => $query,
                'products' => $products,
            ]
        );
    }
}
