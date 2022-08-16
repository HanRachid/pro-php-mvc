<?php

namespace Framework\View\Engine;

use Framework\View\Engine\Contract\Engine;
use Framework\View\View;

class PhpEngine implements Engine
{
    protected string $path;
    protected string $contents ;

    protected ?string $layout ;
    protected function extends(string $template)
    {
        $this->layout = $template;
        return new static();
    }



    public function render(string $path, array $data = []): string
    {
        $this->path = $path;
        extract($data);
        ob_start();
        include($this->path);
        $contents = ob_get_contents();
        ob_end_clean();

        if ($this->layout) {
        }
        if ($this->layout) {
            $__layout = $this->layout;
            $this->layout = null;
            $this->contents = $contents;
            $contentsWithLayout = View::view($__layout, $data);
            return $contentsWithLayout;
        }
        return $contents;
    }

    protected function escape(string $content): string
    {
        return htmlspecialchars($content, ENT_QUOTES);
    }
}
