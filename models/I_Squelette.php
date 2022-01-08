<?php


interface I_Squelette
{
 public function getMenu($num,$pages, $urls, $web_name, $localhost);
 public function getFooter($types,$links,$db_name);

}