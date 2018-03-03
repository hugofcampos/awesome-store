<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\TheIconic;

class ProductController extends Controller
{
    public function list(TheIconic\Products $service) : Response
    {
        $products = $service->get();

        return $this->render(
            'product/list.html.twig',
            ['products' => $products]
        );
    }
}
