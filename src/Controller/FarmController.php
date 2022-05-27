<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Entity\Items;
use App\Entity\Order;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FarmController extends AbstractController
{ /**
    * @Route("/app/farmer", name="farmer")
    */
   public function Farmerindex(RequestStack $requestStack,ManagerRegistry $doctrine)
   {
    
       return  new Response("<h1> index for farmer man<h1>"); 
   }

  
    /**
    * @Route("/app/farmer/products", name="farmer/products")
    */
   public function FarmerProducts(ManagerRegistry $doctrine)
   {
       
       $entityManager=$doctrine->getManager();
       $farm=$doctrine->getRepository(Farm::class)->findOneBy(['owner'=>$this->getUser()]);
       
       return $this->render("farmer/viewProducts.html.twig",['farm'=>$farm]); 
   }


   /**
    * @Route("/app/farmer/{id}/orderNotPrepared", name="farmer/orderNotPrepared")
    */
   public function FarmerOrderNotPrepared(ManagerRegistry $doctrine,int $id)
   {
       $entityManager=$doctrine->getManager();
       $farm=$doctrine->getRepository(Farm::class)->find($id);
      
       $order=$doctrine->getRepository(Order::class)->findBy(['farm'=>$farm,'isPrepared'=>false]);
      
      
     return $this->render("farmer/orderNotPrepared.html.twig",['orders'=>$order,'id'=>$id]); 
   }



   

   /**
    * @Route("/app/farmer/{id}/markPrepared/{idOrder}/{to}", name="farmer/markPrepared")
    */
    public function FarmerOrderMarkPrepared(ManagerRegistry $doctrine,int $id,int $idOrder,int $to)
    {
        $entityManager=$doctrine->getManager();
       
        $order=$doctrine->getRepository(Order::class)->find($idOrder);
        $order->setIsPrepared(true); 
        $entityManager->persist($order);
        $entityManager->flush();
       if($to==0){
        return $this->redirectToRoute("farmer/orderNotPrepared",['id'=>$id]); 
       }
       elseif ($to==1){
        return $this->redirectToRoute("farmer/order",['id'=>$id]); 
       }
     
    }






    /**
    * @Route("/app/farmer/{id}/order", name="farmer/order")
    */
   public function FarmerOrder(ManagerRegistry $doctrine,int $id)
   {
    $entityManager=$doctrine->getManager();
    $farm=$doctrine->getRepository(Farm::class)->find($id);
   
    $order=$doctrine->getRepository(Order::class)->findBy(['farm'=>$farm,'isDelivered'=>false]);
    return $this->render("farmer/allOrder.html.twig",['orders'=>$order,'id'=>$id]); 
   }


    /**
    * @Route("/app/farmer/{id}/delivredOrder", name="farmer/delivredOrder")
    */
    public function FarmerDlivredOrder(ManagerRegistry $doctrine,int $id)
    {
     $entityManager=$doctrine->getManager();
     $farm=$doctrine->getRepository(Farm::class)->find($id);
    
     $order=$doctrine->getRepository(Order::class)->findBy(['farm'=>$farm,'isDelivered'=>true]);
     return $this->render("farmer/viewRecentOrder.html.twig",['orders'=>$order,'id'=>$id]); 
    }





    /**
    * @Route("/app/farmer/sales", name="farmer/sale")
    */
   public function FarmerSales()
   {
      
       return  new Response("<h1>  farmer sales<h1>"); 
   }


    /**
    * @Route("/app/farmer/products/add", name="farmer/products/add")
    */
   public function FarmerAddProducts(ManagerRegistry $doctrine,Request $request )
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
             $farm=$doctrine->getRepository(Farm::class)->findOneBy(['owner'=>$this->getUser()]);
       
           $product->setFarm($farm);
           $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute("farmer/products");

       }
     
       
       
       return $this->renderForm("form/addProduct.html.twig",["form"=>$form]);

      
   }


    /**
    * @Route("/app/farmer/products/delete/{idProd}", name="farmer/products/delete")
    */
   public function FarmerDeleteProduct(ManagerRegistry $doctrine,int $idProd)
   {
       $product=$doctrine->getRepository(Product::class)->find($idProd);
       $entityManager = $doctrine->getManager();
       $entityManager->remove($product);
       $entityManager->flush();
       return $this->redirectToRoute("farmer/products");    
   }
   

    /**
    * @Route("/app/farmer/products/modify/{idProd}", name="farmer/products/modify")
    */
   public function FarmerModify(ManagerRegistry $doctrine,int $idProd,Request $request)
   {
       $entityManager = $doctrine->getManager();
       $product=$entityManager->getRepository(Product::class)->find($idProd);
       $form = $this->createForm(ProductType::class, $product, [
           
           'method' => 'GET',
       ]);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $entityManager->flush();
           return $this->redirectToRoute("farmer/products");

       }
       return  $this->renderForm("form/updateProduct.html.twig",['form'=>$form]);
   }



}
