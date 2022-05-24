<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FarmController extends AbstractController
{ /**
    * @Route("/app/farmer", name="farmer")
    */
   public function Farmerindex(RequestStack $requestStack,ManagerRegistry $doctrine)
   {
    
       return  new Response("<h1> index for farmer man<h1>"); 
   }

  



   // all about farmer 
    /**
    * @Route("/app/farmer/{id}/products", name="farmer/products")
    */
   public function FarmerProducts(ManagerRegistry $doctrine,int $id)
   {
       $entityManager=$doctrine->getManager();
       $farm=$doctrine->getRepository(Farm::class)->find($id);
       $products=$farm->getProducts();

      
       return $this->render("farmer/viewProducts.html.twig",['products'=>$products,'id'=>$id]); 
   }

    /**
    * @Route("/app/farmer/order", name="farmer/order")
    */
   public function FarmerOrder()
   {
      
       return  new Response("<h1> farmer order <h1>"); 
   }

    /**
    * @Route("/app/farmer/sales", name="farmer/sale")
    */
   public function FarmerSales()
   {
      
       return  new Response("<h1>  farmer sales<h1>"); 
   }


    /**
    * @Route("/app/farmer/{id}/products/add", name="farmer/products/add")
    */
   public function FarmerAddProducts(ManagerRegistry $doctrine,Request $request ,int $id)
   {
       // use product id for the moment but when you make the login put haja okhra cuzz it's not secure 
       $product = new Product();
       $form = $this->createForm(ProductType::class, $product, [
           //'action' => $this->generateUrl('farmer/products/add'),
           'method' => 'GET',
       ]);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $entityManager = $doctrine->getManager();
           $product = $form->getData();
           $farm=$doctrine->getRepository(Farm::class)->find($id);
           $product->setFarm($farm);
           $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute("farmer/products",['id'=>$id]);

       }
     
       
       
       return $this->renderForm("form/addProduct.html.twig",["form"=>$form]);

      
   }


    /**
    * @Route("/app/farmer/{id}/products/{idProd}/delete", name="farmer/products/delete")
    */
   public function FarmerDeleteProduct(ManagerRegistry $doctrine,int $id ,int $idProd)
   {
       $product=$doctrine->getRepository(Product::class)->find($idProd);
       $entityManager = $doctrine->getManager();
       $entityManager->remove($product);
       $entityManager->flush();
       return $this->redirectToRoute("farmer/products",['id'=>$id]);

      
      
   }
   

    /**
    * @Route("/app/farmer/{id}/products/{idProd}/modify", name="farmer/products/modify")
    */
   public function FarmerModify(ManagerRegistry $doctrine,int $id ,int $idProd,Request $request)
   {
       $entityManager = $doctrine->getManager();
       $product=$entityManager->getRepository(Product::class)->find($idProd);
       $form = $this->createForm(ProductType::class, $product, [
           
           'method' => 'GET',
       ]);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $entityManager->flush();
           return $this->redirectToRoute("farmer/products",['id'=>$id]);

       }
       return  $this->renderForm("form/updateProduct.html.twig",['form'=>$form]);
   }



}
