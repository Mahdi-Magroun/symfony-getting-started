<?php 
namespace App\Service ; 

use App\Entity\Farm;
use App\Entity\User;
use App\Entity\Greengrocer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

class AdminService 
{

    private $entityManager;
    private $user;
    public function __construct(ManagerRegistry $doctrine,Security $security)
    {
        $this->entityManager=$doctrine->getManager();
        $this->user=$security->getUser();
    }



    public function displayFarms(){
       
        return $this->entityManager->getRepository(Farm::class)->findAll();
    }

    public function getFarmProduct($id){
        $farm=$this->entityManager->getRepository(Farm::class)->find($id);
        return $farm->getProducts();
    }

    public function displayFarmInfo(){

    }

    public function displayGreenGrocer(){
        return $this->entityManager->getRepository(Greengrocer::class)->findAll();
    }

    public function displayGreenGrocerInfo(){

    }

    public function deleteFarm(int $id){
        $farm=$this->entityManager->getRepository(Farm::class)->find($id);
        $user = $farm->getOwner();
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function deleteGreenGrocer($id){
        $gg=$this->entityManager->getRepository(Greengrocer::class)->find($id);
        $user = $gg->getOwnerId();
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }


    public function banFarm($id){
        $farm=$this->entityManager->getRepository(Farm::class)->find($id);
        $user = $farm->getOwner();
       
        $account=$user->getAccount();
        $account->setIsBaned(true);
        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

    public function banGreenGrocer($id){
        $greenGrocer=$this->entityManager->getRepository(Greengrocer::class)->find($id);
        $user = $greenGrocer->getOwnerId();
       
        $account=$user->getAccount();
        $account->setIsBaned(true);
        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

    public function allowFarm($id){
        $farm=$this->entityManager->getRepository(Farm::class)->find($id);
        $user = $farm->getOwner();
       
        $account=$user->getAccount();
        $account->setIsBaned(false);
        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }
    public function allowGreenGrocer($id){
        $greengrocer=$this->entityManager->getRepository(Greengrocer::class)->find($id);
        $user = $greengrocer->getOwnerId();
       
        $account=$user->getAccount();
        $account->setIsBaned(false);
        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }


    public function displayRequest(){

    }

    public function displayRequestInfo(){

    }

    public function acceptRequest($idUser){

    }

    

    public function displayBannedFarm(){

    }

    public function displayAllUser(){

    }

    
    public function displayTotalOrders(){
        // for index 
    }

   
    public function displayTotaleGreenGrocer(){
        // for index
    }

    public function displayTotaleFarm(){
        // public function 
    }

    // al information util for the admin  



    /**
     * add a report system 
     * 
     * 
     * 
     * 
     * 
     * 
     */





}