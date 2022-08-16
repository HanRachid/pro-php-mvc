<?php

namespace Framework\View\Engine\Contract;

interface Engine
{
    public function render(string $path, array $data =[]): string;
}
