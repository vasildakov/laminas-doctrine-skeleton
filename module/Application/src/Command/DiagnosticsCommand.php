<?php declare(strict_types=1);

namespace Application\Command;

use Application\Diagnostics\Reporter\VerboseConsole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Laminas\Diagnostics\Check;
use Laminas\Diagnostics\Result;
use Laminas\Diagnostics\Runner\Runner;
use Laminas\Diagnostics\Runner\Reporter\BasicConsole;

error_reporting(error_reporting() & ~E_DEPRECATED);

final class DiagnosticsCommand extends Command
{
    /**
     * @var array $extensions
     */
    private $extensions = [
        'redis',
        'memcached',
        'pdo',
        'pdo_mysql',
        'bcmath',
        'intl',
        'zip',
        'xml',
        'Zend OPcache'
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('neutrino:diagnostics')
            ->setDescription('Performing application diagnostic tests')
        ;
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Create Runner instance
        $runner = new Runner();

        // Add checks
        $runner->addCheck(new Check\CpuPerformance(0.5)); // at least 50% of EC2 micro instance

        // PHP version and extensions
        $runner->addCheck(new Check\PhpVersion('7.1', '>'));
        $runner->addCheck(new Check\ExtensionLoaded($this->extensions));
        $runner->addCheck(new Check\SecurityAdvisory('composer.lock'));

        // Disk and directories
        $runner->addCheck(new Check\DirWritable('./data/cache'));
        $runner->addCheck(new Check\DiskFree(100000000, './data'));

        // Classes
        $runner->addCheck(new Check\ClassExists([\Redis::class]));

        // Apache
        $apache = new Check\HttpService('localhost');
        $apache->setLabel('Apache is working.');
        $runner->addCheck($apache);


        // Add console reporter
        $console = \Laminas\Console\Console::getInstance();
        $runner->addReporter(new VerboseConsole($console));

        // Run all checks
        $results = $runner->run();

        $status = ($results->getFailureCount() + $results->getWarningCount()) > 0 ? 1 : 0;

        exit($status);
    }
}
