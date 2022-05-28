<?php

namespace App\DataFixtures;

use App\Entity\Farm;
use App\Entity\User;
use App\Entity\Account;
use App\Entity\Greengrocer;
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
      
       
       /* for($i=2;$i<10;$i++){
            $user = new User();
            $account = new Account();
            $account->setIsActivated(false);
            $account->setIsBaned(false);
            $user->setAccount($account);
            $user->setEmail("farmer".$i."@gmail.com");
            $user->setPassword($this->hasher->hashPassword(
                $user,"0101"));
            $user->setRoles(['ROLE_FARMER']);
            $manager->persist($user);
            $farm=new Farm();
            $farm->setOwner($user);
            $farm->setFarmName('farm '.$i);
            $farm->setLoacation('location '.$i);
            
            
         $manager->persist($farm);

        
        }
         $manager->flush();
     */
    }
}
