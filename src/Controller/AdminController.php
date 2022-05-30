<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Entity\Greengrocer;
use App\Service\AdminService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    private $adminService;
    public function __construct(AdminService $adminService)
    {
        $this->adminService=$adminService;
    }

    /**
     * @Route("/app/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

     /**
     * @Route("/app/admin/farms", name="app_admin/farms")
     */
    public function displayFarms(){

       return $this->render('admin/displayFarms.html.twig',['farms'=>$this->adminService->displayFarms()]);
    }

  
    /**
     * @Route("/app/admin/greengrocer", name="app_admin/greengrocer")
     */
    public function displayGreenGrocer(){

        return $this->render('admin/displayGreenGrocer.html.twig',['greengrocer'=>$this->adminService->displayGreenGrocer()]);
     }
 
     /**
     * @Route("/app/admin/deleteFarm/{id}", name="app_admin/deleteFarm")
     */
    public function deleteFarm(int $id){
        $this->adminService->deleteFarm($id);
        return $this->redirectToRoute('app_admin/farms');
    }
   
    /**
     * @Route("/app/admin/deleteGreenGrocer/{id}", name="app_admin/deleteGreenGrocer")
     */
    public function deleteGreenGrocer($id){
        $this->adminService->deleteGreenGrocer($id);
        return $this->redirectToRoute('app_admin/greengrocer');
    }

     /**
     * @Route("/app/admin/farmer/ban/{id}", name="app_admin/farmer/ban")
     */
    public function banFarmer(int $id){
        $this->adminService->banFarm($id); 
        return $this->redirectToRoute('app_admin/farms');
    }

     /**
     * @Route("/app/admin/farmer/allow/{id}", name="app_admin/farmer/allow")
     */
    public function allowFarmer(int $id){
        $this->adminService->allowFarm($id); 
        return $this->redirectToRoute('app_admin/farms');
    }

     /**
     * @Route("/app/admin/greengrocer/ban/{id}", name="app_admin/greengrocer/ban")
     */
    public function banGreenGrocer(int $id){
        $this->adminService->banGreenGrocer($id); 
        return $this->redirectToRoute('app_admin/greengrocer');
    }

     /**
     * @Route("/app/admin/greengrocer/allow/{id}", name="app_admin/greengrocer/allow")
     */
    public function allowGreengrocer(int $id){
        $this->adminService->allowGreenGrocer($id);
        return $this->redirectToRoute('app_admin/greengrocer');
    }

     /**
     * @Route("/app/admin/farmer/{id}/products", name="app_admin/farmer/products")
     */
    public function farmProduct(int $id){ 
        return $this->render('admin/farmProduct.html.twig',['products'=>$this->adminService->getFarmProduct($id)]);
    }


      /**
     * @Route("/app/admin/farm/Request", name="app_admin/farm/request")
     */
    public function farmRequest(){ 
       
        return $this->render('admin/displayFarmRequest.html.twig',['farms'=> $this->adminService->displayFarmRequest()]);
    }

     /**
     * @Route("/app/admin/farm/Request/accept/{id}", name="app_admin/farm/request/accept")
     */
    public function acceptFarmRequest($id){
        $this->adminService->acceptFarmerRequest($id);
        return $this->redirectToRoute("app_admin/farm/request");
        
    }   

    /**
     * @Route("/app/admin/farm/Request/deny/{id}", name="app_admin/farm/request/deny")
     */
    public function denyFarmRequest($id){
        $this->adminService->denyFarmerRequest($id);
        return $this->redirectToRoute("app_admin/farm/request");
    }   


    /**
     * @Route("/app/admin/farm/Request/proves/{id}", name="app_admin/farm/request/proves")
     */
    public function displayFarmInfoAndProves($id,ManagerRegistry $doctrine){
        $farm=$doctrine->getManager()->getRepository(Farm::class)->find($id);
        return $this->render("admin/displayFarmRequestInfo.html.twig",['farm'=>$farm]);
    }   


     /**
     * @Route("/app/admin/greengrocer/Request", name="app_admin/greengrocer/request")
     */
    public function greenGrocerRequest(){ 
       
        return $this->render('admin/displayGreengrocerRequest.html.twig',['greengrocer'=> $this->adminService->displayGreenGrocerRequest()]);
    }

     /**
     * @Route("/app/admin/greengrocer/Request/accept/{id}", name="app_admin/greengrocer/request/accept")
     */
    public function acceptGreenGrocerRequest($id){
        $this->adminService->acceptGreenGrocerRequest($id);
        return $this->redirectToRoute("app_admin/greengrocer/request");
        
    }   

    /**
     * @Route("/app/admin/greengrocer/Request/deny/{id}", name="app_admin/greengrocer/request/deny")
     */
    public function denyGreenGrocerRequest($id){
        $this->adminService->denyGreenGrocerRequest($id);
        return $this->redirectToRoute("app_admin/greengrocer/request");
    }   


    /**
     * @Route("/app/admin/greengrocer/Request/proves/{id}", name="app_admin/greengrocer/request/proves")
     */
    public function displayGreenGrocerInfoAndProves($id,ManagerRegistry $doctrine){
        $greengrocer=$doctrine->getManager()->getRepository(Greengrocer::class)->find($id);
        return $this->render("admin/displayGreenGrocerRequestInfo.html.twig",['greengrocer'=>$greengrocer]);
    }   




}
