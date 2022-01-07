<?php

namespace  Button;
use I_composant\I_Composants;

class Button implements I_Composants
{

    public function getComposant($nom)
    {
        return '<button type="submit" class="btn btn-dark">'.$nom.'</button>';
    }
}