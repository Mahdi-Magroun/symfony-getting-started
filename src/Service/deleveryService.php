<?php
namespace App\Service;
use App\Entity\Order;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

class DeleveryService{

    private $entityManager;
    private $user;

    public function __construct(ManagerRegistry $doctrine,Security $security){
        $this->entityManager=$doctrine->getManager();
        $this->user=$security->getUser();
        
    }

    public function getAllOrders(){
        $order=$this->entityManager->getRepository(Order::class)->findBy(['status'=>'order','isDelivered'=>false]);
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
        return $Orderfarms;
    }
  
}