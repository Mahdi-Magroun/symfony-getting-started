<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Entity\Items;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Greengrocer;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GreenGrocerController extends AbstractController
{
    
      /**
     * @Route("/app/greengrocer", name="greengrocer")
     */
    public function GreenGrocerindex()
    {
        return  new Response( "<h1>index for green grocer</h1>");
    }





    // all about greengrocer 

     /**
     * @Route("/app/greengrocer/{idGreen}/farms", name="greengrocer/farms")
     */
    public function GreenGrocerViewFarms(ManagerRegistry $doctrine,int $idGreen)
    {
        $entityManager=$doctrine->getManager();
        $farms=$entityManager->getRepository(Farm::class)->findAll();
        return  $this->render("greengrocer/viewFarm.html.twig",["farms"=>$farms,'idGreen'=>$idGreen]);

    }

     /**
     * @Route("/app/greengrocer/{idGreen}/farms/{idFarm}/products", name="greengrocer/farms/products")
     */
    public function GreenGrocerViewFarmsProducts(ManagerRegistry $doctrine,int $idFarm,int $idGreen)
    {
        $entityManager=$doctrine->getManager();
        $farms=$entityManager->getRepository(Farm::class)->find($idFarm);
        $products=$farms->getProducts();
        return  $this->render("greengrocer/viewFarmProducts.html.twig",["products"=>$products,'idGreen'=>$idGreen]);

    }

     /**
     * @Route("/app/greengrocer/{idGreen}/farms/{idFarm}/products/addtoshopingCard/{idProduct}", name="greengrocer/farms/products/tocard")
     */
    public function GreenGrocerToShopingCard(ManagerRegistry $doctrine,int $idGreen,int $idFarm,int $idProduct,Request $request){

        $quantite= new class {
            public $quantite;
        };
        $form = $this->createFormBuilder($quantite)
        ->add('quantite', NumberType::class)
        ->add('save', SubmitType::class, ['label' => 'add to card'])
        ->getForm();
        $form->handleRequest($request);
        $entityManager=$doctrine->getManager();
        $product=$entityManager->getRepository(Product::class)->find($idProduct);
        if($form->isSubmitted() && $form->isValid()){

           
        $farm=$entityManager->getRepository(Farm::class)->find($idFarm);
        $greenGrocer=$entityManager->getRepository(Greengrocer::class)->find($idGreen);
        $order=$entityManager->getRepository(Order::class)->findOneBy(['farm'=>$farm,'greengrocer'=>$greenGrocer,'status'=>'card']);
        if($order==null){

        $order = new Order();
        $order->setFarm($farm);
        $order->setGreengrocer($greenGrocer);
        $order->setStatus("card");
       
        }

     
        $item=new Items();
        $item->setProduct($product);
        $item->setOrdor($order);
        $item->setPrice($product->getPrice()*$form->getData()->quantite);
        $item->setQuantite($form->getData()->quantite);
        $order->addItem($item);

        $entityManager->persist($order);
        $entityManager->flush();
        return $this->redirectToRoute('greengrocer/farms/products',['idFarm'=>$idFarm,'idGreen'=>$idGreen]);
    }

    return $this->renderForm('greengrocer/addToCard.html.twig',['form'=>$form,'product'=>$product]);

        
    }





     /**
     * @Route("/app/greengrocer/{idGreen}/mycard", name="greengrocer/mycard")
     */
    public function GreenGrocerMyCard(ManagerRegistry $doctrine,int $idGreen)
    {
        $entityManager=$doctrine->getManager();
        $greenGrocer=$entityManager->getRepository(Greengrocer::class)->find($idGreen);
        $order=$entityManager->getRepository(Order::class)->findBy(['greengrocer'=>$greenGrocer,'status'=>'card']);
       
         return $this->render('greengrocer/card.html.twig',['orders'=>$order]);
    }


     /**
     * @Route("/app/greengrocer/{idGreen}/myorder", name="greengrocer/myorder")
     */
    public function GreenGrocerMyOrder(ManagerRegistry $doctrine,int $idGreen)
    {
        $entityManager=$doctrine->getManager();
        $greenGrocer=$entityManager->getRepository(Greengrocer::class)->find($idGreen);
        $order=$entityManager->getRepository(Order::class)->findBy(['greengrocer'=>$greenGrocer,'status'=>'order']);
       
         return $this->render('greengrocer/order.html.twig',['orders'=>$order]);
    }

     /**
     * @Route("/app/greengrocer/{idGreen}/makeorder/{idCard}", name="greengrocer/makeorder")
     */
    public function GreenGrocerMakeOrder(ManagerRegistry $doctrine,int $idCard , int $idGreen){
        $entityManager=$doctrine->getManager();
        $order=$entityManager->getRepository(Order::class)->find($idCard);
        $order->setStatus('order');
        $entityManager->flush();
        return $this->redirectToRoute('greengrocer/mycard',['idGreen'=>$idGreen]);
    }

     /**
     * @Route("/app/greengrocer/{idGreen}/deletefromCard/{idCard}", name="greengrocer/deletefromcard")
     */
    
    public function GreenGrocerDeleteFromCard(ManagerRegistry $doctrine,int $idCard , int $idGreen)
    {
        $entityManager=$doctrine->getManager();
        $order=$entityManager->getRepository(Order::class)->find($idCard);
        $entityManager->remove($order);
        $entityManager->flush();
        return $this->redirectToRoute('greengrocer/mycard',['idGreen'=>$idGreen]);


        return  new Response( "<h1>view my order </h1>");
    }

    


}
