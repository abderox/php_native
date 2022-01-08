<?php
include_once '../../models/I_Composants.php';

class Button implements I_Composants
{

    public function getComposant($nom)
    {
        return '<button type="submit" class="btn btn-dark">'.$nom.'</button>';
    }
}