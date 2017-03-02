<?php
class DB {
    private static $_instance = null;

    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
            $this->_pdo->exec("set names utf8");
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array()) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if(count($params)) {
                foreach($params as $param) {
                    if (is_int($param)) {
                        $this->_query->bindValue($x, $param, PDO::PARAM_INT);
                    } else {
                        $this->_query->bindValue($x, $param);
                    }

                    $x++;
                }
            }
            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }
            else {
                $this->_error = true;
                print_r($this->_query->errorInfo());
            }
        }
        return $this;
    }
    public function first() {
        return $this->results()[0];
    }
    public function last() {
        $i = count($this->results()) - 1;

        return $this->results()[$i];
    }

    public function results() {
        return $this->_results;
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }

}
