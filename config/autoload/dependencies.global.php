<?php

return [
    'dependencies' => [
        'factories' => [
            Application\Command\ImportDataFixtures::class => Application\Command\ImportDataFixturesFactory::class,
            Application\Command\DiagnosticsCommand::class => Application\Command\DiagnosticsCommandFactory::class,
        ],
    ],
];