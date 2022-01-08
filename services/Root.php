<?php

class Root
{
    public static function rootDirectory()
    {
        return dirname(__FILE__, 2);
    }
}