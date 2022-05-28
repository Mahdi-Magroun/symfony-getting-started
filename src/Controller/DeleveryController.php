<?php

namespace App\Controller;
use App\Service\DeleveryService;
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
     * @Route("/app/delevery/order", name="delevery/order")
     */
    public function DeleveryOrder(DeleveryService $deleveryService)
    {
 
        return $this->render('delevery/order.html.twig',['farms'=>$deleveryService->getAllOrders()]);
    }

     /**
     * @Route("/app/delevery/order/markDelivred/{idOrder}", name="delevery/order/markDelivred")
     */
    public function DeleveryOrderMarkDelivred(ManagerRegistry $doctrine,$idOrder)
    {
        $entityManager=$doctrine->getManager();
        $order=$entityManager->getRepository(Order::class)->find($idOrder);
        $order->setIsDelivered(true);
         $entityManager->persist($order);
         $entityManager->flush();
         return $this->redirectToRoute('delevery/order');
       
    }

     /**
     * @Route("/app/delevery/gain", name="delevery/gain")
     */
    public function DeleveryGain()
    {
        return new Response("<h1>delevery gain <h1>");
    }

}
