<?php

class DBManager{
    private static $instance;
    private $db;

    //On Construct create new PDO object
    public function __construct()
    {
        $this->db = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST,DB_USER,DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    }

   
    /**
     * check if instance exists and return it or create new one
     * @return DBManager
     */
    public static function getInstance():DBManager{
        if (!self::$instance) {
            self::$instance = new DBManager();
        }

        return  self::$instance;
    }


    /**
     * get PDO
     * @return PDO
     */
    public function getPDO():PDO {
        return $this->db;
    }


    /**
    * function to execute queries 
    * @param string 
    * @param ?array
    * @return PDOStatement
    */
    public function query(string $sql, ?array $params = null) : PDOStatement{
        if ($params == null) {
            $query = $this->db->query($sql);
        }else{
            $query = $this->db->prepare($sql);
            $query->execute($params);
        }

        return $query;
    }
}