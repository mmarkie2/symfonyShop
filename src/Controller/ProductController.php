<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\String\Slugger\SluggerInterface;


class ProductController extends AbstractController
{

    /**
     * @Route("/product", name="product_index")
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();


                return $this->render('product/index.html.twig', [
           'products'  =>  $products
        ]);
    }


    /**
     * @Route("/product/create", name="product_create")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function create(Request $request, FileUploader $fileUploader, EntityManagerInterface  $entityManager) : Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();
            if ($file) {
                $filepath = $fileUploader->upload($file);
                $product->setImageFilepath($filepath );
            }

             $entityManager->persist( $product);
             $entityManager->flush();


            return $this->redirectToRoute('product_create');
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/product/{name}", name="product_read")
//     */
//    public function read(): Response
//    {
//        return $this->render('product/index.html.twig', [
//            'controller_name' => 'ProductController',
//        ]);
//    }
//
//    /**
//     * @Route("/product", name="product")
//     */
//    public function index(): Response
//    {
//        return $this->render('product/index.html.twig', [
//            'controller_name' => 'ProductController',
//        ]);
//    }
//    /**
//     * @Route("/product", name="product")
//     */
//    public function index(): Response
//    {
//        return $this->render('product/index.html.twig', [
//            'controller_name' => 'ProductController',
//        ]);
//    }
}
