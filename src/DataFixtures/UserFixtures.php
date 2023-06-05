<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@exemple.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'mdpuser'));
        $user->setName('Dupond');
        $user->setFirstName('Michel');
        $user->setIsValidated(true);

        $manager->persist($user);

        $user1 = new User();
        $user1->setEmail('admin@exemple.com');
        $user1->setRoles(['ROLE_USER','ROLE_ADMIN']);
        $user1->setPassword($this->passwordEncoder->hashPassword($user1, 'mdpadmin'));
        $user1->setName('Martin');
        $user1->setFirstName('Bob');
        $user1->setIsValidated(true);

        $manager->persist($user1);

        $manager->flush();
    }
}
