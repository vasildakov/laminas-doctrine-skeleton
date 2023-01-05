<?php declare(strict_types = 1);

namespace Application\Command;

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;

/**
 * Class ImportFixturesCommandFactory
 * @author     Vasil Dakov <vasildakov@wgmail.com>
 */
final class ImportDataFixturesFactory
{
    /**
     * @param  ContainerInterface $container
     * @return ImportDataFixtures
     */
    public function __invoke(ContainerInterface $container) : ImportDataFixtures
    {
        $config = $container->get('config');

        if (!isset($config['doctrine']['fixtures'])) {
            throw new ServiceNotCreatedException('Missing Doctrine configuration');
        }

        $em       = $container->get(EntityManager::class);
        $loader   = $container->get(Loader::class);
        $executor = $container->get(ORMExecutor::class);
        $purger   = $container->get(ORMPurger::class);

        $command = new ImportDataFixtures($em, $loader, $executor, $purger);
        $command->setPaths($config['doctrine']['fixtures']['paths']);

        return $command;
    }
}
