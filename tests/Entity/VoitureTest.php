<?php

namespace App\Tests\Entity;

use App\Entity\Voiture;
use PHPUnit\Framework\TestCase;

class VoitureTest extends TestCase
{
    public function testConstructeur(): void
    {
        $tesla = (new Voiture())
            ->setMarque("Tesla")
            ->setModele("3");
        $this->assertEquals("Tesla", $tesla->getMarque());
        $this->assertEquals("3", $tesla->getModele());
        $this->assertNull($tesla->getId());
    }
}
