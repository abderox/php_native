<?php
include_once './I_Composants.php';

class Button implements I_Composants
{

    public function getComposant($nom)
    {
        return '<button type="submit" class="btn btn-dark">'.$nom.'</button>';
    }
}