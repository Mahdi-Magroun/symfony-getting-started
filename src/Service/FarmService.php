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
    private $farm ; 

    public function __construct(ManagerRegistry $doctrine,Security $security){
        $this->entityManager=$doctrine->getManager();
        $this->user=$security->getUser();
        $this->farm=$this->user->getMyfarm();

        
    }




    public function getUtilInfoForIndex(){
// get all order 
        // prepare order 
        // not prepared order 
        // delivred order 

        $totale=count($this->entityManager->getRepository(Order::class)->findBy(['farm'=>$this->farm]));
        $notPrepared=count($this->entityManager->getRepository(Order::class)->findBy(['farm'=>$this->farm,'isPrepared'=>false]));
        $preparedNotDelivred=count($this->entityManager->getRepository(Order::class)->findBy(['farm'=>$this->farm
        ,'isPrepared'=>true,'isDelivered'=>false
    ])); 
    $delivred=count($this->entityManager->getRepository(Order::class)->findBy(['farm'=>$this->farm,'isDelivered'=>true]));
    $notDelivred=count($this->entityManager->getRepository(Order::class)->findBy(['farm'=>$this->farm,'isDelivered'=>false  ]));
    $order=['totale'=>$totale,'notPrepared'=>$notPrepared,'preparedNotDelivered'=>$preparedNotDelivred,'delivred'=>$delivred,'notDelivered'=>$notDelivred]; 
    
     // gains ===> should be on delivered order not all order 
    $orders=$this->entityManager->getRepository(Order::class)->findBy(['farm'=>$this->farm,'status'=>'order']);
    $benifits= 0 ;
    foreach ($orders as $od) {

    foreach ($od->getItems() as $item ) {
        $benifits=$benifits+$item->getPrice();
    }
}
    $benifits=$benifits*0.65/1000;

    $product= count($this->entityManager->getRepository(Product::class)->findBy(['Farm'=>$this->farm]));


    $data=['order'=>$order,'benifits'=>$benifits,'products'=>$product];
    return $data;
    

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