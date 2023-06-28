<?php

declare(strict_types=1);

namespace Idiosyncratic\SpiralPhinxBridge\Bootloader;

use Spiral\Boot\Bootloader\Bootloader;

final class PhinxBootloader extends Bootloader
{
    protected const DEPENDENCIES = [
        PhinxConfigBootloader::class,
        PhinxCommandBootloader::class,
    ];
}
