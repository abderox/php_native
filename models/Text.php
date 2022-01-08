<?php
include_once '../../models/I_Composants.php';

class Text implements I_Composants
{
public function getComposant($nom)
{
    return '<div class="form-group">
							<input
							 type="text"
							 name="inHeadline"
							 class="form-control"
							 placeholder='.$nom.'>
						</div>';
}
}