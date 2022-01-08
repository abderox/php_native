<?php

include_once '../../models/I_Squelette.php';

class Vertical_Menu implements I_Squelette
{

    public function getMenu($num, $pages, $urls, $web_name, $localhost)
    {

        $strBET = ' 
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="row" id="body-row">
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
        <ul class="list-group">';

        $strIN=' <nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="'.$localhost.'">
        <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        <span class="menu-collapsed">'.$web_name.'</span>
    </a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
                <a class="nav-link" href="'.$localhost.'">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown d-sm-block d-md-none">
                <a class="nav-link dropdown-toggle" href="#" id="smallerscreenmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Menu </a>
                <div class="dropdown-menu" aria-labelledby="smallerscreenmenu">';

       $strOUT ='<a href="#top" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span id="collapse-icon" class="fa fa-2x mr-3"></span>
                    <span id="collapse-text" class="menu-collapsed">Collapse</span>
                </div>
            </a>
        </ul>
    </div>
    <div class="col p-0">
 ';

        if(count($pages) >= 1) {
            $pageSIZE = $this->menuLinks($pages, $urls,$web_name, $localhost);
        }
        else {
            $pageSIZE=$this->draftMenu($num);
        }
        return $strIN .$pageSIZE[0]. $strBET.$pageSIZE[1].$strOUT;
    }



    public function draftMenu($num)
    {
            $pageLG = $pageSM = "";
            for ($i=1 ; $i<=$num; $i++)
            {
                $pageSM .= '<a class="dropdown-item" href="#top">Page'.$i.'</a>';
                $pageLG .= ' <a href="#" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-tasks fa-fw mr-3"></span>
                    <span class="menu-collapsed">Page'.$i.'</span>
                </div>
            </a>';

            }
        return array($pageSM,$pageLG);
    }

    public function menuLinks($pages, $links, $web_name, $localhost)
    {
        $pageLG = $pageSM = "";

        for ($i=0 ; $i<count($pages); $i++)
        {
            $pageSM .= '<a class="dropdown-item" href="'.$links[$i].'">'.$pages[$i].'</a>';
            $pageLG .= ' <a href="'.$links[$i].'" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-tasks fa-fw mr-3"></span>
                    <span class="menu-collapsed">'.$pages[$i].'</span>
                </div>
            </a>';

        }
        return array($pageSM,$pageLG);
    }

    public function getFooter($types,$links, $db_name)
    {
        // TODO: Implement getFooter() method.
    }
}