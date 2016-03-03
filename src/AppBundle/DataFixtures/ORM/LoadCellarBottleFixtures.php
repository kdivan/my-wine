<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Bottle;
use AppBundle\Entity\BottleType;
use AppBundle\Entity\Category;
use AppBundle\Entity\Cellar;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;
use UserBundle\Entity\User;

class LoadCellarBottleFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('test');
        $user->setEmail('test@gmail.com');
        $user->setPlainPassword('test');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));
        $manager->persist($user);
        $manager->flush();

        $user1 = new User();
        $user1->setUsername('test2');
        $user1->setEmail('test2@gmail.com');
        $user1->setPlainPassword('test2');
        $user1->setEnabled(true);
        $user1->setRoles(array('ROLE_USER'));
        $manager->persist($user1);
        $manager->flush();

        $user2 = new User();
        $user2->setUsername('admin');
        $user2->setEmail('admin@gmail.com');
        $user2->setPlainPassword('admin');
        $user2->setEnabled(true);
        $user2->setRoles(array('ROLE_ADMIN'));
        $manager->persist($user2);
        $manager->flush();

        $cellar = new Cellar();
        $cellar->setName('Cave à vin Test');
        $cellar->setDescription('Ceci est une cave a vin');
        $cellar->setMaxBottles(50);
        $cellar->setImageName('test');
        $cellar->setUser($user);
        $manager->persist($cellar);
        $manager->flush();

        $cellar2 = clone $cellar;
        $cellar2->setName('Cave à vdeux');
        $cellar2->setDescription('Ceci est une cave a vdeux');
        $cellar2->setMaxBottles(100);
        $cellar2->setImageName('test2');
        $cellar2->setUser($user1);
        $manager->persist($cellar2);
        $manager->flush();

        $cellar3 = clone $cellar;
        $cellar3->setName('Cave à vdeux');
        $cellar3->setDescription('Ceci est une cave a vdeux');
        $cellar3->setMaxBottles(100);
        $cellar3->setImageName('test2');
        $cellar3->setUser($user2);
        $manager->persist($cellar3);
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
            $bottle = new Bottle();
            $bottle->setName('Bouteille admin '.$i);
            $bottle->setDescription('Description '.$i);
            $bottle->setBottleType($bottleType);
            $bottle->setBuyingPrice(50);
            $bottle->setCapacity('1L');
            $bottle->setCellar($cellar3);
            $bottle->setCurrency('€');
            $bottle->setVineyard('Test admin '.$i);
            $bottle->setWinemaking('Test admin '.$i);
            $bottle->setVintage(2005);
            $bottle->setImageName('admin.jpg');
            $manager->persist($bottle);

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
