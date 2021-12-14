<?php

include_once './Button.php';
include_once './Text.php';
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
        else {
            return null;
        }

    }
}