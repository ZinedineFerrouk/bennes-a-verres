<?php

namespace App\DataFixtures;

use App\Entity\LastBennesUpdate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LastBennesUpdateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $last = new LastBennesUpdate();
        $last->setUpdatedAt(new \DateTimeImmutable());
        $last->setErroredUpdate(false);
        $manager->persist($last);

        $manager->flush();
    }
}
