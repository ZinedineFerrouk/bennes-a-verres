<?php

namespace App\Service\Database;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Database handler service
 */
class DatabaseService
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}
