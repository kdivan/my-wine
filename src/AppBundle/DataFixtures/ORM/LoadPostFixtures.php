<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;

class LoadPostFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $i = 0;
        $category = new Category();
        $category->setName("Test");
        $manager->persist($category);
        $manager->flush();

        while($i <= 5){
            $post = new Post();
            $post->setTitle("Test ".$i);
            $post->setBody("TESTESTST");
            $post->setIsPublished(true);
            $post->setCategory($category);
            $manager->persist($post);

            $post = new Post();
            $post->setTitle("Testddddd ".$i);
            $post->setBody("TESTESTST");
            $post->setIsPublished(false);
            $post->setCategory($category);
            $manager->persist($post);

            $i++;
        }
        $manager->flush();
    }
}