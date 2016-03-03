<?php

namespace AppBundle\Services;

use AppBundle\Repository\BottleRepository;
use AppBundle\Repository\CellarRepository;
use Doctrine\ORM\EntityRepository;

class CellarManager
{
    protected $bottleRepository;

    protected $cellarRepository;

    public function __construct(EntityRepository $bottleRepository, EntityRepository $cellarRepository)
    {
        $this->bottleRepository = $bottleRepository;
        $this->cellarRepository = $cellarRepository;
    }


}