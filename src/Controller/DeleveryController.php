<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
