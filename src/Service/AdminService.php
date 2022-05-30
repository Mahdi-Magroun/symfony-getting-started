<?php 
namespace App\Service ;

use App\Entity\Account;
use App\Entity\Farm;
use App\Entity\User;
use App\Entity\Greengrocer;
use App\Entity\Order;
use App\Entity\Product;
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



    public function getUsefullDataForAdmin(){ // account , order , users
        //request 
         // how many banned user 
         $totaleBaned= count($this->entityManager->getRepository(Account::class)->findBy(['isBaned'=>true]));
      // how many request 
        $totaleRequest= count($this->entityManager->getRepository(Account::class)->findBy(['isActivated'=>false]));
        // active Account
        $totaleActive= count($this->entityManager->getRepository(Account::class)->findBy(['isActivated'=>true,'isBaned'=>false]));
        // inactive accounts 
        $totaleInActive = $totaleBaned+$totaleRequest;
        $totaleAccount= $totaleActive+$totaleInActive;
        $account=['totale'=>$totaleAccount,'active'=>$totaleActive,'inactive'=>$totaleInActive,'banned'=>$totaleBaned,'onHold'=>$totaleRequest];


        // order :  // totale order , delivred order , not prepared , prepared and not delivred 
        $totaleOrder= count($this->entityManager->getRepository(Order::class)->findAll());
        $totaleOrderNotPrepared= count($this->entityManager->getRepository(Order::class)->findBy(['isPrepared'=>false]));
        $totaleOrderPreparedAndNotDelivred=count($this->entityManager->getRepository(Order::class)->findBy(['isPrepared'=>true,
        'isDelivered'=>false]));
        $totaleOrderNotDelivred  = $totaleOrderNotPrepared+$totaleOrderPreparedAndNotDelivred;
        $totaleDelivred = $totaleOrder-$totaleOrderNotDelivred;


        
        $orderInfo=['totale'=>$totaleOrder,'notPrepared'=>$totaleOrderNotPrepared,'preparedNotDelivred'=>$totaleOrderPreparedAndNotDelivred
        ,'totaleNotDelivred'=>$totaleOrderNotDelivred,'totaleDelivred'=>$totaleDelivred];

        // how many user in app 
        $totaleUser= count($this->entityManager->getRepository(User::class)->findAll());
        $totaleFarmer= count($this->entityManager->getRepository(User::class)->findUsersByRole("ROLE_FARMER"));
        $totaleGreengrocer= count($this->entityManager->getRepository(User::class)->findUsersByRole("ROLE_GREENGROCER"));
        $totaleDelevery= count($this->entityManager->getRepository(User::class)->findUsersByRole("ROLE_DELEVERY"));
        $totaleAdmin= count($this->entityManager->getRepository(User::class)->findUsersByRole("ROLE_ADMIN"));
       $userInfo=['totale'=>$totaleUser,'totaleFarmer'=>$totaleFarmer,'totaleGreengrocer'=>$totaleGreengrocer
       ,'totaleDelevery'=>$totaleDelevery,'totaleAdmin'=>$totaleAdmin];
    

       
        // benefits 
        $totaleOrder=$this->entityManager->getRepository(Order::class)->findAll();
        $benefits = 0;
        foreach ($totaleOrder as $order) {
             foreach ($order->getItems() as $item) {
                 $benefits=$benefits+$item->getPrice();
             }
        }
        $benefits= $benefits/1000*0.2;
        

         // totale products 
         $totaleProducts=count($this->entityManager->getRepository(Product::class)->findAll());


        $data = ['account'=>$account,'user'=>$userInfo,'order'=>$orderInfo,'benifits'=>$benefits,'totaleProducts'=>$totaleProducts];
       return $data;

    }


















    public function displayFarms(){
        $accounts =$this->entityManager->getRepository(Account::class)->findBy(['isActivated'=>true
    ]);
    $farms=array();
    foreach ($accounts as $account) {
        if( in_array('ROLE_FARMER',$account->getUser()->getRoles()))
        array_push($farms,$account->getUser()->getMyfarm());
    }
    return $farms;
       
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


    public function displayFarmRequest(){
        $accounts =$this->entityManager->getRepository(Account::class)->findBy(['isActivated'=>false
    ]);
    $farms=array();
    foreach ($accounts as $account) {
        if( in_array('ROLE_FARMER',$account->getUser()->getRoles()))
        array_push($farms,$account->getUser()->getMyfarm());
    }
    return $farms;
    }

    public function displayGreenGrocerRequest(){
        $accounts =$this->entityManager->getRepository(Account::class)->findBy(['isActivated'=>false
    ]);
    $greenGrocer=array();
    foreach ($accounts as $account) {
        if( in_array('ROLE_GREENGROCER',$account->getUser()->getRoles()))
        array_push($greenGrocer,$account->getUser()->getGreengrocer());
    }
    return $greenGrocer;
    }
    

    public function displayRequestInfo(){

    }


    public function acceptFarmerRequest($id){
        
        $farm=$this->entityManager->getRepository(Farm::class)->find($id);
        $account=$farm->getOwner()->getAccount();
        $account->setIsActivated(true);
        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

    public function denyFarmerRequest($id){
        $farm=$this->entityManager->getRepository(Farm::class)->find($id);
        $user=$farm->getOwner();
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }


    public function acceptGreenGrocerRequest($id){
        $gg=$this->entityManager->getRepository(Greengrocer::class)->find($id);
        $account=$gg->getOwnerId()->getAccount();
        $account->setIsActivated    (true);
        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

    public function denyGreenGrocerRequest($id){
        $greengrocer=$this->entityManager->getRepository(Greengrocer::class)->find($id);
        $user=$greengrocer->getOwnerId();
        $this->entityManager->remove($user);
        $this->entityManager->flush();
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