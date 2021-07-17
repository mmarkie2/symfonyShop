<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProductFixtures extends Fixture
{



    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 5; $i++)
        {
            $product = new Product();
            $product->setName('product'.$i);
            $product->setPrice($i);
            $product->setDescription('descdescdescdescdesc descdescdescdescdescdescdesc'.$i);
            $product->setImageFilepath("Bez-nazwy-60f2b4dd1f882.png");
            $manager->persist($product);
        }

        $manager->flush();
    }
}
