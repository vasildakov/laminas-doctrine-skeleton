<?php

namespace Application\Factory;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Psr\Container\ContainerInterface;

class ORMExecutorFactory
{
    /**
     * @param   ContainerInterface   $container
     * @return  ORMExecutor
     */
    public function __invoke(ContainerInterface $container) : ORMExecutor
    {
        $em     = $container->get(EntityManager::class);
        $purger = $container->get(ORMPurger::class);

        return new ORMExecutor($em, $purger);
    }
}