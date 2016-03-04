<?php

namespace Tests\AppBundle\Util;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CellarManagerTest extends KernelTestCase
{
    public $cellarManagerService;
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->cellarManagerService = static::$kernel->getContainer()
            ->get('appbundle.cellar_manager');
    }

    public function testHasEnoughSpace()
    {
    }
}