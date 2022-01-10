<?php


namespace View;


class Redirect_
{
    function __construct()
    {

    }

    public static function To($page)
    {
        header('Location:'.$page);
    }
}