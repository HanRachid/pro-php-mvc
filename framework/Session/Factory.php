<?php

namespace Framework\Session;

use Closure;
use Framework\Session\Driver\Driver;
use Framework\Session\Exception\DriverException;

class Factory
{
    protected array $drivers;

    public function addDriver(string $alias, Closure $driver): static
    {
        $this->drivers[$alias] = $driver;
        return $this;
    }

    public function connect(array $config): Driver
    {
        if (!isset($config['type'])) {
            throw new DriverException('type is not defined');
        }

        $type = $config['type'];

        if (isset($this->drivers[$type])) {
            return $this->drivers[$type]($config);
        }

        throw new DriverException('unrecognised type');
    }
}
