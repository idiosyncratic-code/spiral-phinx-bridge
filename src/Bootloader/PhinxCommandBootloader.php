<?php

declare(strict_types=1);

namespace Idiosyncratic\SpiralPhinxBridge\Bootloader;

use Phinx\Config\ConfigInterface as PhinxConfig;
use Phinx\Console\Command\Breakpoint;
use Phinx\Console\Command\Create;
use Phinx\Console\Command\ListAliases;
use Phinx\Console\Command\Migrate;
use Phinx\Console\Command\Rollback;
use Phinx\Console\Command\SeedCreate;
use Phinx\Console\Command\SeedRun;
use Phinx\Console\Command\Status;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Console\Bootloader\ConsoleBootloader;
use Spiral\Core\Container;

final class PhinxCommandBootloader extends Bootloader
{
    public function boot(
        Container $container,
        ConsoleBootloader $console,
        PhinxConfig $phinxConfig,
    ) : void {
        $container->bindSingleton(Create::class, static function (PhinxConfig $phinxConfig) {
            return (new Create('phinx:create'))->setConfig($phinxConfig);
        });

        $console->addCommand(Create::class);

        $container->bindSingleton(Status::class, static function (PhinxConfig $phinxConfig) {
            return (new Status('phinx:status'))->setConfig($phinxConfig);
        });

        $console->addCommand(Status::class);

        $container->bindSingleton(Migrate::class, static function (PhinxConfig $phinxConfig) {
            return (new Migrate('phinx:migrate'))->setConfig($phinxConfig);
        });

        $console->addCommand(Migrate::class);

        $container->bindSingleton(Rollback::class, static function (PhinxConfig $phinxConfig) {
            return (new Rollback('phinx:rollback'))->setConfig($phinxConfig);
        });

        $console->addCommand(Rollback::class);

        $container->bindSingleton(Breakpoint::class, static function (PhinxConfig $phinxConfig) {
            return (new Breakpoint('phinx:breakpoint'))->setConfig($phinxConfig);
        });

        $console->addCommand(Breakpoint::class);

        $container->bindSingleton(SeedCreate::class, static function (PhinxConfig $phinxConfig) {
            return (new SeedCreate('phinx:seed:create'))->setConfig($phinxConfig);
        });

        $console->addCommand(SeedCreate::class);

        $container->bindSingleton(SeedRun::class, static function (PhinxConfig $phinxConfig) {
            return (new SeedRun('phinx:seed:run'))->setConfig($phinxConfig);
        });

        $console->addCommand(SeedRun::class);

        $container->bindSingleton(ListAliases::class, static function (PhinxConfig $phinxConfig) {
            return (new ListAliases('phinx:list:aliases'))->setConfig($phinxConfig);
        });

        $console->addCommand(ListAliases::class);
    }
}
