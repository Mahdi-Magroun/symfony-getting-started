<?php

namespace App\DataFixtures;

use App\Entity\Farm;
use App\Entity\Greengrocer;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->hasher=$userPasswordHasher;
        
    }
    public function load(ObjectManager $manager ): void
    {
      
      /* 
        for($i=2;$i<10;$i++){
            $user = new User();
            $user->setEmail("greengrocer".$i."@gmail.com");
            $user->setPassword($this->hasher->hashPassword(
                $user,"0101"));
            $user->setRoles(['ROLE_GREENGROCER']);
            $manager->persist($user);
            $farm=new Greengrocer();
            $farm->setOwnerId($user);
            $farm->setGreengrocerName('greengrocer '.$i);
            $farm->setLocation('location '.$i);
            
            
         $manager->persist($farm);

        
        }
         $manager->flush();
     */  
    }
}
