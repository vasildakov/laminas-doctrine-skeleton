<?php declare(strict_types=1);

namespace Application\Command;

use Psr\Container\ContainerInterface;

/**
 * Class DiagnosticsCommandFactory
 *
 * @author Vasil Dakov <vasildakov@gmail.com>
 * @copyright 2009-2022 Neutrino.bg
 * @version 1.0
 */
final class DiagnosticsCommandFactory
{
    public function __invoke(ContainerInterface $container) : DiagnosticsCommand
    {
        return new DiagnosticsCommand();
    }
}
