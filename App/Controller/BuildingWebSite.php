<?php


namespace BuildingWebSite;

use BaseController\BaseController;
use StaticVars\StaticVariables;
use View\Redirect_;
use View\render_;
use View\render_1;

class BuildingWebSite
{

    public function index()
    {
        $view = new render_1('./index');
        $user = 'hello';
        $view->render_([$user]);
    }
}