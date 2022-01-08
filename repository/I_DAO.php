<?php

interface I_DAO
{
    public function findAll();
    public function findById($id);
    public function findOneBy($col_name, $criteria);
}