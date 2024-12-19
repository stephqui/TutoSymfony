<?php
//Pour remplir de la donnée en DB
//'composer require --dev orm-fixtures'

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@doe.fr')
            ->setUsername('admin')
            ->setVerified(true)
            ->setPassword($this->hasher->hashPassword($user, 'admin'))
            ->setApiToken('admin_token');
        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++) {
            $user = (new User())
                ->setRoles([])
                ->setEmail("user{$i}@doe.fr")
                ->setUsername("user{$i}")
                ->setVerified(true)
                ->setPassword($this->hasher->hashPassword($user, '0000'))
                ->setApiToken("user{$i}");
            $manager->persist($user);
        }
        $manager->flush();
    }
}
