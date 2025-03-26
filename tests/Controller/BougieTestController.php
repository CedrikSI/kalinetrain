<?php 

namespace App\tests\Controller;

use App\Entity\Bougie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BougieTestController extends WebTestCase
{



    public function TestBougiePage()
    {
        $client = static::createClient();
        $client->request('GET', '/bougie');
        $this->assertResponseIsSuccessful();
    }       


}
