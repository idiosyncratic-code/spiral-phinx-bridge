<?php

declare(strict_types=1);

namespace Idiosyncratic\SpiralPhinxBridge;

use Spiral\Core\InjectableConfig;

final class PhinxConfig extends InjectableConfig
{
    public const CONFIG = 'phinx';

    /** @var array{
     * 'migration_paths': array<string>,
     * 'seed_paths': array<string>,
     * 'default_migration_table': string,
     * 'environments': array<string,array<string, mixed>>,
     * 'version_order': string
     * }
     */
    protected array $config = [
        'migration_paths' => [],
        'seed_paths' => [],
        'default_migration_table' => '',
        'environments' => [],
        'version_order' => '',
    ];

    /** @return array<string> */
    public function getMigrationPaths() : array
    {
        return $this->config['migration_paths'];
    }

    /** @return array<string> */
    public function getSeedPaths() : array
    {
        return $this->config['seed_paths'];
    }

    public function getDefaultMigrationTable() : string
    {
        return $this->config['default_migration_table'];
    }

    /** @return array<string, array<string, mixed>> */
    public function getEnvironments() : array
    {
        return $this->config['environments'];
    }

    public function getVersionOrder() : string
    {
        return $this->config['version_order'];
    }
}
