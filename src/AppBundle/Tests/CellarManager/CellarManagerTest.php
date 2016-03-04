<?php
namespace AppBundle\Tests\CellarManager;

class CellarManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testHasEnoughSpace()
    {
        $this->setExpectedException("InvalidArgumentException",'The letter "1" is not a valid ASCII character matching [a-z].');

        $game = new Game("test");
        $game->tryLetter(1);
    }
}