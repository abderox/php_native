<?php


class Headline implements I_Composants
{

    public function getComposant($nom)
    {
        return ' <div class="row justify-content-center">
    <h1>'.$nom.'</h1>
  </div>';
    }
}