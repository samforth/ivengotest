<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/", name="homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/product/list", name="product-list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productListAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/product/create", name="product-create")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productCreateAction(Request $request)
    {
        $product = new Product();

        if ($request->isMethod('post')) {
            $product->setName($request->get('name'));
            $product->setPrice($request->get('price'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product-list');
        }

        return $this->render('product/create.html.twig');
    }
}