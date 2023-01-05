<?php

declare(strict_types=1);

namespace Application;


class Module
{
    public function onBootstrap(\Laminas\EventManager\EventInterface $e)
    {
        $application    = $e->getTarget();
        $serviceManager = $application->getServiceManager();
        $eventManager   = $e->getApplication()->getEventManager();
        $sharedManager  = $eventManager->getSharedManager();

        $config = $e->getApplication()->getServiceManager()->get('config');
        $config = $e->getTarget()->getServiceManager()->get('Config');


        // laminas developer toolbar
        if (isset($config['laminas-developer-tools']['profiler']['enabled'])
            && $config['laminas-developer-tools']['profiler']['enabled']
        ) {
            // when Laminas\DeveloperTools is enabled, initialize the sql collector
            $application->getServiceManager()->get('doctrine.sql_logger_collector.orm_default');
        }
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'doctrine.sql_logger_collector.orm_default' => new \DoctrineORMModule\Service\SQLLoggerCollectorFactory('orm_default'),
            ],
        ];
    }
    
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
}
