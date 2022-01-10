<?php


namespace BuildingWebSite;

use BaseController\BaseController;
use StaticVars\StaticVariables;
use View\Redirect_;
use View\render_;
use View\render_1;

include_once './App/Vendor/view_/render_.php';

class BuildingWebSite
{
    public static function index()
    {
        $view = new render_('./App/Controller/index');
        $user = ['kaoutar','abdelhadi'];
        $view->render('vara',$user);
    }
}