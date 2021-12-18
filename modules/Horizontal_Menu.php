<?php

include_once './I_Squelette.php';

class Horizontal_Menu implements I_Squelette
{




    public function getMenu($num, $pages, $urls, $web_name, $localhost)
    {
        $strIN=' <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">';

        $strOUT ='
    
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>';


        if(count($pages) >= 1) {
            $page = $this->menuLinks($pages, $urls, $web_name, $localhost);
        }
        else {
            $page = $this->draftMenu($num);
        }
        return $strIN .$page .$strOUT;

    }



    public function draftMenu($num)
    {
            $page ="";
        $page .= str_repeat('<li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>', $num);
        return $page;
    }

    public function menuLinks($pages, $links, $web_name, $localhost)
    {
        $page ="";
        for ($i=0 ; $i<count($pages); $i++)
        {
            $page .='<li class="nav-item">
        <a class="nav-link" href="'.$links[$i].'">'.$pages[$i].'</a>
      </li>' ;

        }
        return $page;
    }

    public function getFooter($types,$links, $db_name)
    {
        // TODO: Implement getFooter() method.
    }
}