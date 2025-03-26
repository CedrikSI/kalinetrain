<?php 

namespace App\tests\Entity;

use App\Entity\Bougie;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BougieTest extends KernelTestCase
{
    
    
    public function getEntity(): Bougie
    {
        return (new Bougie())
            ->setNom('Bougie') 
            ->setCouleur('rouge')
            ->setPoid(0.5)
            ->setDdv(3)
            ->setTaille(10);
    }
    
    public function assertHasErrors(Bougie $bougie, string $message, int $number = 0): void
    {
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($bougie);
        $this->assertCount($number, $error, $message);
    }

    public function testvalidEntity()
    {
        $this->assertHasErrors($this->getEntity(), "Test de validation de l'entité Bougie", 0);
    }

    public function testInvalidEntity()
    {
    $message = "La valeur de Ddv doit être comprise entre 1 et 4.";
    $this->assertHasErrors($this->getEntity()->setDdv(0), $message, 1);
    }

    public function testBlankValueEntity()
    {
        $message = "La valeur ne peut pas être nul.";
    $this->assertHasErrors($this->getEntity()->setNom(""), $message, 1);
    }

}