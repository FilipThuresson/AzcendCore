<?php

namespace Azcend\Core;

class GenerateFile
{
    public static function create_controller($className) {
        $txt = '<?php

namespace Azcend\Controllers;

class '.$className.'Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): void
    {
        $this->view(\''. strtolower($className) . '.index\');
    }
}
        ';

        return $txt;
    }
}