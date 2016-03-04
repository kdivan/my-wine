<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Cellar;

class CellarManager
{
    protected $bottleRepository;

    protected $cellarRepository;

    public function __construct(EntityRepository $bottleRepository, EntityRepository $cellarRepository)
    {
        $this->bottleRepository = $bottleRepository;
        $this->cellarRepository = $cellarRepository;
    }

    public function hasEnoughStorage(Cellar $cellar, $bottleToStore)
    {
        return count($this->bottleRepository->findBy(['cellar' => $cellar]))
            + $bottleToStore <= $cellar->getMaxBottles();
    }

    public function getAvailableSpace(Cellar $cellar)
    {
        return $cellar->getMaxBottles() -
            count($this->bottleRepository->findBy(['cellar' => $cellar]));
    }
}
