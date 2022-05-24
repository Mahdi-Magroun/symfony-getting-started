<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Entity\User;
use App\Entity\Items;
use App\Entity\Order;
use App\Entity\Product;
use App\Form\ProductType;
use App\Entity\Greengrocer;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController

{

   



 /**
     * @Route("/app/farmer/login", name="login")
     */
    public function index(RequestStack $requestStack,ManagerRegistry $doctrine): Response
    {
        $request=Request::createFromGlobals();
        if($request->get('usermail')!=null && $request->get("userpassword")!=null){
            $entityManager=$doctrine->getManager();
            $user=null;
            $user=$entityManager->getRepository(User::class)->findOneBy(['email' =>$request->get('usermail'),'password' =>$request->get('userpassword') ]);
            if($user!=null)
            {
                $session =$requestStack->getSession();
                $session->set('user',['email'=>$request->get('usermail'),'password'=>$request->get('userpassword')]);
                return $this->redirectToRoute('farmer');
            }
            
        }

        return $this->render("\login\login.html.twig",[]);
    }


   


    

}
