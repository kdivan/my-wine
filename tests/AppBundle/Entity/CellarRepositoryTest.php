<?php
namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CellarRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByUser()
    {
        $products = $this->em
            ->getRepository('AppBundle:Cellar')
            ->findAll()
        ;
        $this->assertCount(3, $products);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
    }
}