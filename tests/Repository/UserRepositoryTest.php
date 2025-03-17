<?php
   
   namespace App\test\Repository;

use App\Kernel;
use PHPUnit\Framework\TestCase;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

   class UserRepositoryTest extends KernelTestCase
   {

      use FixturesTrait;

       public function testCount()
       {
           self::bootKernel();
           $this->loadFixtures([UserFixtures::class]);
           $users = self::$container->get(UserRepository::class)->count([]);
           $this->assertEquals(10, $users);
       }
   }  