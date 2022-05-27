<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Entity\Items;
use App\Entity\Order;
use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FarmService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FarmController extends AbstractController
{ 
    private $farmService;
    public function __construct(FarmService $farmService)
    {
        $this->farmService= $farmService;
    }
    
    /**
    * @Route("/app/farmer", name="farmer")
    */
   public function Farmerindex()
   {
    
       return  new Response("<h1> index for farmer man<h1>"); 
   }

  
    /**
    * @Route("/app/farmer/products", name="farmer/products")
    */
   public function FarmerProducts()
   {
    return $this->render("farmer/viewProducts.html.twig",['farm'=>$this->farmService->getCurentFarm()]); 
   }


   /**
    * @Route("/app/farmer/orderNotPrepared", name="farmer/orderNotPrepared")
    */
   public function FarmerOrderNotPrepared(ManagerRegistry $doctrine)
   {
      
      
     return $this->render("farmer/orderNotPrepared.html.twig",['orders'=>$this->farmService->getNonPreparedOrder()]); 
   }



   

   /**
    * @Route("/app/farmer/markPrepared/{idOrder}/{to}", name="farmer/markPrepared")
    */
    public function FarmerOrderMarkPrepared(int $idOrder,int $to)
    {
        $this->farmService->markOrderAsPrepared($idOrder);
        
       if($to==0){
        return $this->redirectToRoute("farmer/orderNotPrepared"); 
       }
       elseif ($to==1){
        return $this->redirectToRoute("farmer/order"); 
       }
     
    }






    /**
    * @Route("/app/farmer/order", name="farmer/order")
    */
   public function FarmerOrder(ManagerRegistry $doctrine)
   {
    return $this->render("farmer/allOrder.html.twig",['orders'=>$this->farmService->getAllFarmOrder()]); 
   }


    /**
    * @Route("/app/farmer/delivredOrder", name="farmer/delivredOrder")
    */
    public function FarmerDlivredOrder(ManagerRegistry $doctrine)
    {
     return $this->render("farmer/viewRecentOrder.html.twig",['orders'=>$this->farmService->getDelivredOrders()
    ]); 
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
       $this->farmService->deleteProduct($idProd);
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
