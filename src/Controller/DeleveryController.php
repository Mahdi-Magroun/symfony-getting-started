<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Entity\Order;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleveryController extends AbstractController
{
    // index pages 

     /**
     * @Route("/app/delevery", name="delevery")
     */
    public function Deleveryindex()
    {
        return new Response("<h1> index for delevery man<h1>");
    }
    

    // all about devery man 


     /**
     * @Route("/app/delevery/{id}/order", name="delevery/order")
     */
    public function DeleveryOrder(ManagerRegistry $doctrine,int $id )
    {
        $entityManager=$doctrine->getManager();
        $order=$entityManager->getRepository(Order::class)->findBy(['status'=>'order','isDelivered'=>false]);
        $farmsId=array();
        for($i=0;$i<count($order);$i++){
            array_push($farmsId,$order[$i]->getFarm()->getId());
        }
        $farmsId=array_unique($farmsId,SORT_NUMERIC);
        $farmsId=array_values($farmsId);    
        $Orderfarms=array();
        
        for($i=0;$i<count($farmsId);$i++){
            $qq=array();
             for ($j=0; $j <count($order) ; $j++) { 
                if($order[$j]->getFarm()->getId()==$farmsId[$i]){
                    $poid=0;
                    foreach ($order[$j]->getItems() as $item) {
                       $poid=$poid+$item->getQuantite();
                    }
                array_push($qq,['order'=>$order[$j],'weight'=>$poid]);
                }
             }
             array_push($Orderfarms,['orders'=>$qq,'farm'=>$qq[0]['order']->getFarm()]);
            
        }
      
       
        return $this->render('delevery/order.html.twig',['farms'=>$Orderfarms,'id'=>$id]);
    }

     /**
     * @Route("/app/delevery/{id}/order/markDelivred/{idOrder}", name="delevery/order/markDelivred")
     */
    public function DeleveryOrderMarkDelivred(ManagerRegistry $doctrine,int $id,$idOrder)
    {
        $entityManager=$doctrine->getManager();
        $order=$entityManager->getRepository(Order::class)->find($idOrder);
        $order->setIsDelivered(true);
         $entityManager->persist($order);
         $entityManager->flush();
         return $this->redirectToRoute('delevery/order',['id'=>$id]);
       
    }

     /**
     * @Route("/app/delevery/gain", name="delevery/gain")
     */
    public function DeleveryGain()
    {
        return new Response("<h1>delevery gain <h1>");
    }

}
