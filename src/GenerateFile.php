<?php

namespace Azcend\Core;

class GenerateFile
{
    public static function create_controller($className) {
        $txt = '<?php

namespace Azcend\Controllers;

class '.$className.'Controller extends BaseController
{
    public function index(): void
    {
        $this->view(\''. strtolower($className) . '.index\');
    }
}
        ';

        return $txt;
    }
}