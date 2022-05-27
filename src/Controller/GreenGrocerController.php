<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Entity\User;
use App\Entity\Items;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Greengrocer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GreenGrocerController extends AbstractController
{
    
      /**
     * @Route("/app/greengrocer", name="greengrocer")
     */
    public function GreenGrocerindex(ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher)
    {
       /* $user=new User();
        $entityManager=$doctrine->getManager();
        $user->setEmail('delevery1@gmail.com');
        $user->setRoles(['ROLE_DELEVERY']);
       
        $user->setPassword($userPasswordHasher->hashPassword(
            $user,"0101"));
        
        $entityManager->persist($user);
        $entityManager->flush();
*/
        return  new Response( "<h1>index for green grocer</h1>");
    }





    // all about greengrocer 

     /**
     * @Route("/app/greengrocer/farms", name="greengrocer/farms")
     */
    public function GreenGrocerViewFarms(ManagerRegistry $doctrine)
    {
        $entityManager=$doctrine->getManager();
        $farms=$entityManager->getRepository(Farm::class)->findAll();
        return  $this->render("greengrocer/viewFarm.html.twig",["farms"=>$farms]);

    }

     /**
     * @Route("/app/greengrocer/farms/{idFarm}/products", name="greengrocer/farms/products")
     */
    public function GreenGrocerViewFarmsProducts(ManagerRegistry $doctrine,int $idFarm)
    {
        $entityManager=$doctrine->getManager();
        $farms=$entityManager->getRepository(Farm::class)->find($idFarm);
        return  $this->render("greengrocer/viewFarmProducts.html.twig",["farms"=>$farms]);

    }

     /**
     * @Route("/app/greengrocer/farms/{idFarm}/products/addtoshopingCard/{idProduct}", name="greengrocer/farms/products/tocard")
     */
    public function GreenGrocerToShopingCard(ManagerRegistry $doctrine,int $idFarm,int $idProduct,Request $request){

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

        $greenGrocer=$entityManager->getRepository(Greengrocer::class)->findOneBy(['owner_id'=>$this->getUser()->getId()]);
        $farm=$entityManager->getRepository(Farm::class)->find($idFarm);
        $order=$entityManager->getRepository(Order::class)->findOneBy(['farm'=>$farm,'greengrocer'=>$greenGrocer,'status'=>'card']);
        if($order==null){

        $order = new Order();
        $order->setFarm($farm);
        $greenGrocer=$entityManager->getRepository(Greengrocer::class)->findOneBy(['owner_id'=>$this->getUser()]);
        $order->setGreengrocer($greenGrocer);
        $order->setStatus("card");
        $order->setIsDelivered(false);
        $order->setIsPrepared(false);
       
        }

     
        $item=new Items();
        $item->setProduct($product);
        $item->setOrdor($order);
        $item->setPrice($product->getPrice()*$form->getData()->quantite);
        $item->setQuantite($form->getData()->quantite);
        $order->addItem($item);
        $product->setQuantity($product->getQuantity()-$item->getQuantite());
        $entityManager->persist($product);
        $entityManager->persist($order);
        $entityManager->flush();
        return $this->redirectToRoute('greengrocer/farms/products',['idFarm'=>$idFarm]);
    }

    return $this->renderForm('greengrocer/addToCard.html.twig',['form'=>$form,'product'=>$product]);

        
    }




     /**
     * @Route("/app/greengrocer/mycard", name="greengrocer/mycard")
     */
    public function GreenGrocerMyCard(ManagerRegistry $doctrine)
    {
       
      //  dd($this->getUser()->getId());
        $entityManager=$doctrine->getManager();
        $greenGrocer=$entityManager->getRepository(Greengrocer::class)->findOneBy(['owner_id'=>$this->getUser()->getId()]);
        $order=$entityManager->getRepository(Order::class)->findBy(['greengrocer'=>$greenGrocer,'status'=>'card']);
       // dd($this->getUser());
      // dd($greenGrocer);
         return $this->render('greengrocer/card.html.twig',['orders'=>$order]);
    }


     /**
     * @Route("/app/greengrocer/myorder", name="greengrocer/myorder")
     */
    public function GreenGrocerMyOrder(ManagerRegistry $doctrine)
    {
        $entityManager=$doctrine->getManager();
        $greenGrocer=$entityManager->getRepository(Greengrocer::class)->findOneBy(['owner_id'=>$this->getUser()->getId()]);         
        $order=$entityManager->getRepository(Order::class)->findBy(['greengrocer'=>$greenGrocer,'status'=>'order','isDelivered'=>false]);
       
         return $this->render('greengrocer/order.html.twig',['orders'=>$order]);
    }

     /**
     * @Route("/app/greengrocer/makeorder/{idCard}", name="greengrocer/makeorder")
     */
    public function GreenGrocerMakeOrder(ManagerRegistry $doctrine,int $idCard){
        $entityManager=$doctrine->getManager();
        $order=$entityManager->getRepository(Order::class)->find($idCard);
        $order->setStatus('order');
        $item=$order->getItems();
        foreach ($item as $key ) {
            $key->getProduct()->setQuantity($key->getProduct()->getQuantity()-$key->getQuantite());
            
        }
        $entityManager->persist($order);
        $entityManager->flush();
        return $this->redirectToRoute('greengrocer/mycard');
    }



    /**
     * @Route("/app/greengrocer/recentOrder", name="greengrocer/recentOrder")
     */
    public function GreenGrocerRecentOrder(ManagerRegistry $doctrine){
    
     $entityManager=$doctrine->getManager();
     $greenGrocer=$entityManager->getRepository(Greengrocer::class)->findOneBy(['owner_id'=>$this->getUser()->getId()]);      
     $order=$doctrine->getRepository(Order::class)->findBy(['greengrocer'=>$greenGrocer,'isDelivered'=>true]);
     return $this->render("greengrocer/viewRecentOrder.html.twig",['orders'=>$order]); 
    
    }




     /**
     * @Route("/app/greengrocer/deletefromCard/{idCard}", name="greengrocer/deletefromcard")
     */
    
    public function GreenGrocerDeleteFromCard(ManagerRegistry $doctrine,int $idCard , int $idGreen)
    {
        $entityManager=$doctrine->getManager();
        $order=$entityManager->getRepository(Order::class)->find($idCard);
        $entityManager->remove($order);
        $entityManager->flush();
        return $this->redirectToRoute('greengrocer/mycard',['idGreen'=>$idGreen]);
    }

    


}
