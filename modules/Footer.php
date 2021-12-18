<?php
include_once './I_Squelette.php';
class Footer implements I_Squelette
{

    public function getFooter($types,$links,$db_name)
    {

        $strIN = '<footer class="bg-dark text-center text-white" style=" bottom: 0; width: 100%">
  <!-- Grid container -->
  <div class="container p-4 pb-0">
    <!-- Section: Social media -->
    <section class="mb-4">';

        $strSM = $this->footerLinks($types, $links);

    $strOUT = '</section>
    <!-- Section: Social media -->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2021 Copyright:
    <a class="text-white" href="#">'.$db_name.count($links).'</a>
  </div>
  <!-- Copyright -->
</footer>';

    return $strIN.$strSM.$strOUT;
    }

    public function footerLinks($types, $urls)
    {
        $str_sm = "";

        for ($i=0 ; $i<count($urls); $i++)
        {
            $str_sm .= '<a class="btn btn-outline-light btn-floating m-1" href="'.$urls[$i].'" role="button"
        ><i class="fab fa-'.$types[$i].'"></i
      ></a>';
        }
        return $str_sm;
    }


    public function getMenu($num, $pages, $urls, $web_name, $localhost)
    {
        // TODO: Implement getMenu() method.
    }
}