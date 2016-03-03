<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Bottle;
use AppBundle\Entity\BottleType;
use AppBundle\Entity\Category;
use AppBundle\Entity\Cellar;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;

class LoadCellarBottleFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cellar = new Cellar();
        $cellar->setName('Cave à vin Test');
        $cellar->setDescription('Ceci est une cave a vin');
        $cellar->setMaxBottles(50);
        $cellar->setImageName('test');
        $manager->persist($cellar);
        $manager->flush();

        $cellar2 = clone $cellar;
        $cellar2->setName('Cave à vdeux');
        $cellar->setDescription('Ceci est une cave a vdeux');
        $cellar->setMaxBottles(100);
        $cellar->setImageName('test2');
        $manager->persist($cellar2);
        $manager->flush();

        $bottleType = new BottleType();
        $bottleType->setLabel('Vin rouge');
        $manager->persist($bottleType);
        $manager->flush();

        $bottleType2 = clone $bottleType;
        $bottleType2->setLabel('Vin blanc');
        $manager->persist($bottleType2);
        $manager->flush();

        $i = 0;
        //First cellar
        while ($i <= 5) {
            if ($i % 2 == 0) {
                $bottle = new Bottle();
                $bottle->setName('Bouteille '.$i);
                $bottle->setDescription('Description '.$i);
                $bottle->setBottleType($bottleType);
                $bottle->setBuyingPrice(50);
                $bottle->setCapacity('1L');
                $bottle->setCellar($cellar);
                $bottle->setCurrency('€');
                $bottle->setVineyard('Test Vineyard '.$i);
                $bottle->setWinemaking('Test winemaking '.$i);
                $bottle->setVintage(2005);
                $bottle->setImageName('test.jpg');
                $manager->persist($bottle);
            } else {
                $bottle2 = new Bottle();
                $bottle2->setName('Bouteille '.$i);
                $bottle2->setDescription('Description '.$i);
                $bottle2->setBottleType($bottleType2);
                $bottle2->setBuyingPrice(50);
                $bottle2->setCapacity('1L');
                $bottle2->setCellar($cellar2);
                $bottle2->setCurrency('€');
                $bottle2->setVineyard('Test Vineyard '.$i);
                $bottle2->setWinemaking('Test winemaking '.$i);
                $bottle2->setVintage(2005);
                $bottle2->setImageName('test2.jpg');
                $manager->persist($bottle2);
            }
            $i++;
        }
        $manager->flush();
    }
}
