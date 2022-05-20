<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Farm;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController

{

    // index pages 

     /**
     * @Route("/app/delevery", name="delevery")
     */
    public function Deleveryindex()
    {
        return new Response("<h1> index for delevery man<h1>");
    }
     /**
     * @Route("/app/farmer", name="farmer")
     */
    public function Farmerindex()
    {
       
        return  new Response("<h1> index for farmer man<h1>"); 
    }

     /**
     * @Route("/app/greengrocer", name="greengrocer")
     */
    public function GreenGrocerindex()
    {
        return  new Response( "<h1>index for green grocer</h1>");
    }




    // all about farmer 
     /**
     * @Route("/app/farmer/products", name="farmer/products")
     */
    public function FarmerProducts(ManagerRegistry $doctrine )
    {
        $entityManager=$doctrine->getManager();
        $farm=$doctrine->getRepository(Farm::class)->find(3);
        $products=$farm->getProducts();

       
        return  new Response("<h1>in this farm there is".count($products)." product</h1>"); 
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
     * @Route("/app/farmer/products/add", name="farmer/products/add")
     */
    public function FarmerAddProducts(ManagerRegistry $doctrine )
    {
        $entityManager = $doctrine->getManager();
        $farm=$doctrine->getRepository(Farm::class)->find(3);
        $product = new Product();
        $product->setFarm($farm);
        $product->setProductName('tomato 2');
        $product->setProductDiscription('fresh tomato 2');
        $product->setPrice(2.5);
        $product->setQuantity(4000);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
       
        return  new Response("<h1> product aded succesfully <h1>"); 
    }


     /**
     * @Route("/app/farmer/products/delete", name="farmer/products/delete")
     */
    public function FarmerDeleteProduct()
    {
       
        return  new Response("<h1>  delete product <h1>"); 
    }
    

     /**
     * @Route("/app/farmer/products/modify", name="farmer/products/modify")
     */
    public function FarmerModify()
    {
       
        return  new Response("<h1> modify <h1>"); 
    }



    // all about greengrocer 

     /**
     * @Route("/app/greengrocer/farms", name="greengrocer/farms")
     */
    public function GreenGrocerViewFarms(ManagerRegistry $doctrine)
    {
        $entityManager=$doctrine->getManager();
        $farms=$entityManager->getRepository(Farm::class)->findAll();
        return  new Response( "<h1>view farmers ".count($farms)." farm</h1>");
    }

     /**
     * @Route("/app/greengrocer/myorder", name="greengrocer/myorder")
     */
    public function GreenGrocerMyOrder()
    {
        return  new Response( "<h1>view my order </h1>");
    }

     /**
     * @Route("/app/greengrocer/farms/makeorder", name="greengrocer/farms/makeorder")
     */
    public function GreenGrocerMakeOrder()
    {
        return  new Response( "<h1>make order </h1>");
    }



    // all about devery man 


     /**
     * @Route("/app/delevery/order", name="delevery/order")
     */
    public function DeleveryOrder()
    {
        return new Response("<h1>delevery order<h1>");
    }

     /**
     * @Route("/app/delevery/order/detail", name="delevery/order/detail")
     */
    public function DeleveryOrderDetail()
    {
        return new Response("<h1>delevery order detail <h1>");
    }

     /**
     * @Route("/app/delevery/gain", name="delevery/gain")
     */
    public function DeleveryGain()
    {
        return new Response("<h1>delevery gain <h1>");
    }















}
