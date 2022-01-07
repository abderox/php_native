<?php
namespace FactoryComposant;
use Button\Button;
use Footer\Footer;
use Horizontal_Menu\Horizontal_Menu;
use Text\Text;
use Vertical_Menu\Vertical_Menu;

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