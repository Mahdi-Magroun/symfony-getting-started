<?php

namespace App\DataFixtures;

use App\Entity\Farm;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      
       
        for($i=2;$i<10;$i++){
            $user = new User();
            $user->setEmail("farmer".$i."@gmail.com");
            $user->setPassword("password".$i);
            $user->setRoles(['ROLE'=>'FARMER']);
            $manager->persist($user);
            $farm=new Farm();
            $farm->setOwner($user);
            $farm->setFarmName('farm '.$i);
            $farm->setLoacation('location '.$i);
            
            
         $manager->persist($farm);

        
        }
         $manager->flush();
       
    }
}
