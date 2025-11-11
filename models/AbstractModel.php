<?php 

abstract class AbstractModel{
    protected $id = null;
    protected DBManager $db;


    protected function __construct()
    {
        $this->db = DBManager::getInstance();
    }
}