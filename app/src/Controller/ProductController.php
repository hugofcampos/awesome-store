<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function list() : Response
    {
        return $this->render(
            'product/list.html.twig',
            ['products' => [1,2,3]] // just an example
        );
    }
}
