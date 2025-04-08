<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setFirstname('Elisa');
        $admin->setLastname('Simonet');
        $admin->setEmail('gickelokabi@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, '11.Germain')); // Remplacez "admin123" par un mot de passe sécurisé

        $manager->persist($admin);
        $manager->flush();
    }
}