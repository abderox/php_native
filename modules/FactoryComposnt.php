<?php

include_once './Button.php';
include_once './Text.php';
include_once './Horizontal_Menu.php';
include_once './Vertical_Menu.php';
include_once './Footer.php';
class FactoryComposnt
{
    public function choose($param )
    {

        if ($param == 'text')
        {
            return  new Text();
        }
        elseif ($param == 'button')
        {
            return  new Button();
        }
        elseif ($param == 'vertical')
        {
            return  new Vertical_Menu();
        }
        elseif ($param == 'horizontal')
        {
            return  new Horizontal_Menu();
        }
        elseif ($param == 'footer')
        {
            return  new Footer();
        }
        else {
            return null;
        }

    }
}