<?php
namespace App\Service;

use App\Entity\Farm;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

class FarmService{

    private $entityManager;
    private $user;

    public function __construct(ManagerRegistry $doctrine,Security $security){
        $this->entityManager=$doctrine->getManager();
        $this->user=$security->getUser();
        
    }

    public function getCurentFarm(  ){
      return  $farm=$this->entityManager->getRepository(Farm::class)->findOneBy(['owner'=>$this->user]);
       
    }
    public function getNonPreparedOrder(){
        $farm=$this->entityManager->getRepository(Farm::class)->findOneBy(['owner'=>$this->user]);
       return  $order=$this->entityManager->getRepository(Order::class)->findBy(['farm'=>$farm,'isPrepared'=>false]);
       
    }

    public function markOrderAsPrepared(int $idOrder){
        $order=$this->entityManager->getRepository(Order::class)->find($idOrder);
        $order->setIsPrepared(true); 
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function getAllFarmOrder(){
        $farm=$this->entityManager->getRepository(Farm::class)->findOneBy(['owner'=>$this->user]);
        return $this->entityManager->getRepository(Order::class)->findBy(['farm'=>$farm,'isDelivered'=>false]);
    }
    
    public function getDelivredOrders(){
        $farm=$this->entityManager->getRepository(Farm::class)->findOneBy(['owner'=>$this->user]);
        return  $this->entityManager->getRepository(Order::class)->findBy(['farm'=>$farm,'isDelivered'=>true]);
    }

    public function deleteProduct($id){
        $product=$this->entityManager->getRepository(Product::class)->find($id);
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}