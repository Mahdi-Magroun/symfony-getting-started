<?php

namespace App\DataFixtures;

use App\Entity\Farm;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         //$entityManager=$doctrine->getManager();
        $farm=$manager->getRepository(Farm::class)->find(3);
       
       /* for($i=0;$i<30;$i++){
            $product = new Product();
            $product->setFarm($farm);
            $product->setPrice(100+$i);
            $product->setQuantity(1000+$i);
            $product->setProductName("product ".$i);
            $product->setProductDiscription("product discription ".$i);
            $manager->persist($product);
            
        // $manager->persist($product);

        
        }
         $manager->flush();
         */
    }
    }

