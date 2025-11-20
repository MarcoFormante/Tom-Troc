<?php 

require_once('./models/AbstractEntityManager.php');
require_once('./models/DBManager.php');

abstract class AbstractFixture extends AbstractEntityManager
{

    protected function createRandomString():string
    {
        $letters = "abcdefghilmnopqrstuvywmh";
        $randomString = substr(str_shuffle($letters),rand(1,12),rand(12,25));

        return $randomString;
    }


    protected function createRandomCount()
    {
        return rand(2,10);
    }
}