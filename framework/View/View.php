<?php

namespace Framework\View;

use Framework\View\Manager;
use Framework\View\Engine\PhpEngine;
use Framework\View\Engine\BasicEngine;

class View
{
    public static $manager= null;
    public static function view(string $template, array $data = []): string
    {
        if (!static::$manager) {
            $manager = new Manager();
            // let's add a path for our views folder
            // so the manager knows where to look for views
            $manager->addPath(__DIR__ . '/../../resources/views');
            // we'll also start adding new engine classes
            // with their expected extensions to be able to pick
            // the appropriate engine for the template
            $manager->addEngine('php', new PhpEngine());
            $manager->addEngine('basic.php', new BasicEngine());
        }

        return $manager->render($template, $data);
    }
}
