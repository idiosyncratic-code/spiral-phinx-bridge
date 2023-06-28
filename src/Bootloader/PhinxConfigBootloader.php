<?php

declare(strict_types=1);

namespace Idiosyncratic\SpiralPhinxBridge\Bootloader;

use Idiosyncratic\SpiralPhinxBridge\PhinxConfig;
use Phinx\Config\Config as PhinxLibraryConfig;
use Phinx\Config\ConfigInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\DirectoriesInterface;
use Spiral\Boot\EnvironmentInterface;
use Spiral\Config\ConfigManager;
use Spiral\Config\Patch\Append;
use Spiral\Core\Container;

use function array_merge;

final class PhinxConfigBootloader extends Bootloader
{
    public function __construct(
        private readonly ConfigManager $configurator,
    ) {
    }

    public function init(
        EnvironmentInterface $env,
        DirectoriesInterface $directories,
    ) : void {
        if (! $directories->has('database')) {
            $directories->set('database', $directories->get('app') . 'database');
        }

        $this->configurator->setDefaults(PhinxConfig::CONFIG, [
            'migration_paths' => [],
            'seed_paths' => [],
            'default_migration_table' => $env->get('PHINX_MIGRATION_TABLE', 'phinxlog'),
            'environments' => [],
            'version_order' => $env->get('PHINX_VERSION_ORDER', 'execution'),
        ]);

        $this->addMigrationPath($directories->get('database') . 'migrations');
        $this->addSeedPath($directories->get('database') . 'seeds');
    }

    public function boot(
        Container $container,
        PhinxConfig $config,
    ) : void {
        $container->bindSingleton(ConfigInterface::class, static function (PhinxConfig $config) {
            return new PhinxLibraryConfig([
                'paths' => [
                    'migrations' => $config->getMigrationPaths(),
                    'seeds' => $config->getSeedPaths(),
                ],
                'environments' => array_merge(
                    [
                        'default_migration_table' => $config->getDefaultMigrationTable(),
                    ],
                    $config->getEnvironments(),
                ),
                'version_order' => $config->getVersionOrder(),
            ]);
        });
    }

    public function addMigrationPath(
        string $migrationPath,
    ) : void {
        $this->configurator->modify(
            PhinxConfig::CONFIG,
            new Append('migration_paths', null, $migrationPath),
        );
    }

    public function addSeedPath(
        string $seedPath,
    ) : void {
        $this->configurator->modify(
            PhinxConfig::CONFIG,
            new Append('seed_paths', null, $seedPath),
        );
    }

    public function addEnvironment(
        string $environment,
        string $adapter,
        string $host,
        string $dbname,
        int $port,
        string $user,
        string $pass,
        string $charset,
    ) : void {
        $this->configurator->modify(
            PhinxConfig::CONFIG,
            new Append(
                'environments',
                $environment,
                [
                    'adapter' => $adapter,
                    'host' => $host,
                    'name' => $dbname,
                    'port' => $port,
                    'user' => $user,
                    'pass' => $pass,
                    'charset' => $charset,
                ],
            ),
        );
    }
}
