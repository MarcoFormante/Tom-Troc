<?php 

abstract class AbstractEntityManager{
    protected DBManager $db;

    public function __construct()
    {
        $this->db = DBManager::getInstance();
    }
}