<?php

namespace Framework\View;

use Exception;
use Framework\View\Engine\Contract\Engine;

class Manager
{
    protected array $paths = [];
    protected array $engines = [];

    public function addPath(string $path)
    {
        array_push($this->paths, $path);

        return new static();
    }

    public function addEngine(string $extension, Engine $engine)
    {
        $this->engines[$extension] = $engine;
        return new static();
    }

    public function render(string $template, array $data =[]): string
    {
        foreach ($this->engines as $extension => $engine) {
            foreach ($this->paths as $path) {
                $file = "{$path}/{$template}.{$extension}";

                if (is_file($file)) {
                    return $engine->render($file, $data);
                }
            }
        }
        throw new Exception("Could not render '{view}'");
    }
}
